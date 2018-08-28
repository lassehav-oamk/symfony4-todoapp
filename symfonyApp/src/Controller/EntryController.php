<?php
/**
 * Created by PhpStorm.
 * User: lassehav
 * Date: 28.8.2018
 * Time: 12.58
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EntryController extends AbstractController
{
    public function entry()
    {
        return $this->render('entry/index.html.twig');
    }
}