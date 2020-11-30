<?php

namespace App\DataFixtures;

use App\Entity\Category;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    const CATEGORIES = [
        "PC",
        "PS4",
        "Nintendo",
        "Xbox"
    ];

    public function load(ObjectManager $manager)
    {
        $i = 0;
        foreach (self::CATEGORIES as $categoryName){
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $this->addReference('category'.$i, $category);
            $i++;
        }
        $manager->flush();
    }


}
