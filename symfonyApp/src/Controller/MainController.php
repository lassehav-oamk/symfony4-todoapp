<?php
namespace App\Controller;


use App\Entity\Todo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    public function todoList()
    {
       /* $todos = array(
            array('id' => 1,
                  'description' => 'Get apples',
                  'dueDate' => '2001-03-10',
                  'isDone' => true),
            array('id' => 2,
                'description' => 'Learn Symfony',
                'dueDate' => '2018-09-20',
                'isDone' => false),
            array('id' => 3,
                'description' => 'Buy milk',
                'dueDate' => '2018-10-01',
                'isDone' => false),
            );*/

        $todos = $this->getDoctrine()
            ->getRepository(Todo::class)
            ->findAll();

        return $this->render('todoList.html.twig', array(
            'todos' => $todos,
        ));
    }
}
