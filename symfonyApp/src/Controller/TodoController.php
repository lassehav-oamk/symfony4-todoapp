<?php

namespace App\Controller;

use App\Entity\Todo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TodoController extends AbstractController
{
    public function viewTodo($id)
    {
        $todo = $this->getDoctrine()->getManager()->getRepository(Todo::class)->find($id);

        $form = $this->createFormBuilder($todo)
            ->add('description', TextType::class)
            ->add('dueDate', DateType::class)
            ->add('isDone',  ChoiceType::class, array(
                'choices'  => array(
                    'Yes' => true,
                    'No' => false,
                )))
            ->add('save', SubmitType::class, array('label' => 'Save Changes'))
            ->add('delete', SubmitType::class, array('label' => 'Delete'))
            ->getForm();

        return $this->render('todo/viewTodo.html.twig', [
            'todo' => $todo,
            'form' => $form->createView()
        ]);
    }
}
