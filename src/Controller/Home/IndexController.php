<?php
/**
 * Created by PhpStorm.
 * User: hocin
 * Date: 15/07/2019
 * Time: 21:04
 */

namespace App\Controller\Home;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{

    /**
     * Accueil
     * @return Response
     */
    public function index()
    {
        return $this->render('home/index.html.twig');
    }
}