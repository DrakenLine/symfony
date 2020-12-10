<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\GameType;
use App\Form\ProfileFormType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     * @Route("/user/{id<\d+>}", name="user_details")
     */
    public function details(User $user = null): Response
    {
    	$user = $user ? $user : $this->getUser();
    	if( ! $user){
    		return $this->redirectToRoute('login');
    	}
        return $this->render('user/details.html.twig', [
        	'user' => $user
        ]);
    }

    /**
     * @Route("/profile/edit/{id<\d+>}", name="profile_edit")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */


    public function updateProfile(User $user, Request $request, EntityManagerInterface $em)
    {
        $profileForm = $this->createForm(ProfileFormType::class, $user);
        $profileForm->handleRequest($request); //form prend en charge la requête
        if ($profileForm->isSubmitted() && $profileForm->isValid()) {
            /**
             * @var User $user
             */
            $user = $profileForm->getData();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Votre profil a bien été modifié !');
            return $this->redirectToRoute('profile', [
                'id' => $user->getId()
            ]);
        }
        return $this->render('user/profile-form.html.twig', [
            'profile_form' =>$profileForm->createView()
        ]);
    }

    /**
     * @Route("/profile/update-password", name="profile_update_password")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */

    public function updatePassword(Request $request, EntityManagerInterface  $manager, UserPasswordEncoderInterface $encoder){
        $user = $this->getUser();

        $passwordForm = $this->createForm(ChangePasswordFormType::class);

        $passwordForm->handleRequest($request); //form prend en charge la requête

        if ($passwordForm->isSubmitted() && $passwordForm->isValid()){
            $newPassword = $passwordForm->get('newPassword')->getData();
            $encodedPassword = $encoder->encodePassword($user, $newPassword); //mdp encodé
            $user->setPassword($encodedPassword);
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('profile');
        }

        return $this->render('user/password-form.html.twig', [
            'password_form'=>$passwordForm->createView()
        ]);
    }
}
