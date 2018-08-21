<?php
/**
 * Created by PhpStorm.
 * User: lassehav
 * Date: 20.8.2018
 * Time: 10.04
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class NewTodo extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction($options['action'])
            ->add('description', TextType::class)
            ->add('dueDate', DateType::class, array('widget' => 'single_text', 'format' => 'dd.MM.yyyy'));
    }

}