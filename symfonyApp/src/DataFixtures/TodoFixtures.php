<?php

namespace App\DataFixtures;

use App\Entity\Todo;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TodoFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $descriptions = array(
            'Get milk',
            'Learn Symfony',
            'Create entity fixtures',
            'Load data in controller',
            'Add input UI',
            'Implement POST request');

        for($i = 0; $i < count($descriptions); $i++)
        {
            $date = new \DateTime();
            $date->add(new \DateInterval('P' . $i . 'D'));

            $todo = new Todo();
            $todo->setDescription($descriptions[$i]);
            $todo->setIsDone(false);
            $todo->setDueDate($date);
            $manager->persist($todo);
        }

        $testUser = new User();
        $testUser->setEmail('test@test');
        $testUser->setUsername('tester');
        $testUser->setSalt('abcdef');
        $testUser->setPassword(password_hash('test_password', PASSWORD_BCRYPT));
        $manager->persist($testUser);

        $manager->flush();
    }
}
