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

        $testUser = new User();
        $testUser->setEmail('test@test');
        $testUser->setUsername('tester');
        $testUser->setSalt('abcdef');
        $testUser->setPassword(password_hash('test_password', PASSWORD_BCRYPT));

        $testUser2 = new User();
        $testUser2->setEmail('test2@test2');
        $testUser2->setUsername('tester2');
        $testUser2->setSalt('abcdef');
        $testUser2->setPassword(password_hash('test_password2', PASSWORD_BCRYPT));

        for($i = 0; $i < count($descriptions); $i++)
        {
            $date = new \DateTime();
            $date->add(new \DateInterval('P' . $i . 'D'));

            $todo = new Todo();
            $todo->setDescription($descriptions[$i]);
            $todo->setIsDone(false);
            $todo->setDueDate($date);
            $todo->setOwner($i % 2 ? $testUser : $testUser2);
            $manager->persist($todo);
        }

        $manager->persist($testUser);
        $manager->persist($testUser2);

        $manager->flush();
    }
}
