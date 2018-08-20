<?php

namespace App\Controller;

use App\Entity\Todo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\NewTodo;

class TodoController extends AbstractController
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

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();

            if($form->get('save')->isClicked())
            {
                // $form->getData() holds the submitted values
                // but, the original `$task` variable has also been updated
                $todo = $form->getData();

                // ... perform some action, such as saving the task to the database
                // for example, if Task is a Doctrine entity, save it!

                $entityManager->persist($todo);
                $entityManager->flush();

                return $this->redirectToRoute('todoUpdateSuccess', ['id' => $id]);
            }
            else if($form->get('delete')->isClicked())
            {
                $todo = $entityManager->getRepository(Todo::class)->find($id);
                $entityManager->remove($todo);

                $entityManager->flush();

                // Todo redirect to delete ok
                return $this->redirectToRoute('todoDeleteSuccess', ['id' => $id]);
            }
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


    public function todoDeleted($id)
    {
        return $this->render('todo/todoDeleted.html.twig', ['id' => $id]);
    }

    public function todoAddNew(Request $request)
    {
        $newTodo = new Todo();
        $newForm = $this->createForm(NewTodo::class, $newTodo);

        $newForm->handleRequest($request);

        if ($newForm->isSubmitted() && $newForm->isValid())
        {
            $newTodo = $newForm->getData();
            $newTodo->setIsDone(false);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newTodo);
            $entityManager->flush();

            return $this->redirectToRoute('todoList');
        }
        else
        {
            return $this->render('todo/todoAddFailed.html.twig');
        }
    }
}
