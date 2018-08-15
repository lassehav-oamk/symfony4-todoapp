<?php
namespace App\Controller;


use App\Entity\Todo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    public function todoList()
    {
        $todos = $this->getDoctrine()
            ->getRepository(Todo::class)
            ->findAll();

        return $this->render('todoList.html.twig', array(
            'todos' => $todos,
        ));
    }
}
