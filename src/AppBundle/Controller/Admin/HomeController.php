<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    /**
     * @Route("/", name="admin_home", methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        return $this->render('admin/home/home.html.twig');
    }
}
