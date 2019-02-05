<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DefaultController extends AbstractController
{


    public function home()
    {
        return $this->render('site/layout.html.twig');
    }

    public function admin()
    {
        return $this->render('admin/base.html.twig');
    }
	
}