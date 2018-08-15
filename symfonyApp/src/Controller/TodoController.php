<?php

namespace App\Controller;

use App\Entity\Todo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class TodoController extends AbstractController
{
    public function viewTodo(Request $request, $id)
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

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $todo = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($todo);
            $entityManager->flush();

            return $this->redirectToRoute('todoUpdateSuccess', ['id' => $id]);
        }

        return $this->render('todo/viewTodo.html.twig', [
            'todo' => $todo,
            'form' => $form->createView()
        ]);
    }

    public function todoUpdated($id)
    {
        $todo = $this->getDoctrine()->getManager()->getRepository(Todo::class)->find($id);

        return $this->render('todo/todoUpdated.html.twig', ['todo' => $todo]);
    }
}
