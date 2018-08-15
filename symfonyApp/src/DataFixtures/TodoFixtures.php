<?php

namespace App\DataFixtures;

use App\Entity\Todo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TodoFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $descriptions = array(
            'Get milk',
            'Learn Symfony',
            'Create entity fixtures',
            'Load data in controller',
            'Add input UI',
            'Implement POST request');

        $date = new \DateTime();

        for($i = 0; $i < count($descriptions); $i++)
        {
            $todo = new Todo();
            $todo->setDescription($descriptions[$i]);
            $todo->setIsDone(false);
            $todo->setDueDate($date);
            $manager->persist($todo);

            $date->add(new \DateInterval('P1D'));

        }

        $manager->flush();
    }
}
