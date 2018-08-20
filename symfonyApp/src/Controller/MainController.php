<?php
namespace App\Controller;


use App\Entity\Todo;
use App\Form\NewTodo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MainController extends AbstractController
{
    public function todoList()
    {
        $todos = $this->getDoctrine()
            ->getRepository(Todo::class)
            ->findAll();

        $newTodo = new Todo();
        $newForm = $this->createForm(NewTodo::class, $newTodo, array('action' => $this->generateUrl('todoAddNew')));
        $newForm->add('save', SubmitType::class);

        return $this->render('todoList.html.twig', array(
            'todos' => $todos,
            'newTodoForm' =>  $newForm->createView()
        ));
    }
}
