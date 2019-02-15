<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class DefaultController extends AbstractController
{
	private $session;

	public function __construct(SessionInterface $session)
	{
       $this->session = $session;
	}
	
    public function home(Request $request, TranslatorInterface $translator)
    {
        !$this->session->get('_locale') ? $this->session->set('_locale', 'pt') : false;
		return $this->render('base.html.twig', array('translator'=>$translator));
    }

    public function admin()
    {
        return $this->render('admin/base.html.twig');
    }
	
	public function userTranslation($lang)
    {    
        $this->session->set('_locale', $lang);
        return $this->redirectToRoute('home');
    }
}