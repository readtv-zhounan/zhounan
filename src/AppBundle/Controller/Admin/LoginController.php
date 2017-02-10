<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/")
 */
class LoginController extends Controller
{
    /**
     * @Route("login", name="admin_login", methods={"GET"})
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();
        $username = $authenticationUtils->getLastUsername();
        $failurePath = $this->get('request_stack')->getMasterRequest()->getUri();

        return $this->render('admin/login/login.html.twig', compact('error', 'username', 'failurePath'));
    }
}
