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

class SeasirenController extends AbstractController
{
	private $session;

	public function __construct(SessionInterface $session)
	{
       $this->session = $session;
	}
	
    public function home(Request $request, TranslatorInterface $translator)
    {
		$request = $request->getlocale();
		
		$pageInfo = array();
		$pageInfo = array('title'=> $translator->trans('home.title'), 'sub_title' => $translator->trans('home.sub_title'), 'text' => $translator->trans('home.text'));
		
		$products = array();
		$products[] = array('title' => $translator->trans('home.cave_costal.title_unlimited'),'text' => $translator->trans('home.cave_costal.text_unlimited'),'image' => '/assets/images/pano-thumb.jpg');
		$products[] = array('title' => $translator->trans('home.cave_costal.title_benagil_cave'),'text' => $translator->trans('home.cave_costal.text_benagil_cave'),'image' => '/assets/images/benagil-thumb.jpg');
		$products[] = array('title' => $translator->trans('home.cave_costal.title_benagil_sunset'),'text' => $translator->trans('home.cave_costal.text_benagil_sunset'),'image' => '/assets/images/sunset-thum-3.jpg');
		
		$privates = array();
		$privates[] = array('desc' => $translator->trans('home.private.title_list.kids_party'), 'image' => 'berlin1t.jpg', 'href' => '#');
		$privates[] = array('desc' => $translator->trans('home.private.title_list.private_tour'), 'image' => 'berlin2t.jpg', 'href' => '#');
		$privates[] = array('desc' => $translator->trans('home.private.title_list.marrige_wedding'), 'image' => 'berlin3t.jpg', 'href' => '#');
		$privates[] = array('desc' => $translator->trans('home.private.title_list.team_building'), 'image' => 'berlin1t.jpg', 'href' => '#');
		$privates[] = array('desc' => $translator->trans('home.private.title_list.gift_voucher'), 'image' => 'berlin2t.jpg', 'href' => '#');
		$privates[] = array('desc' => $translator->trans('home.private.title_list.photografy'), 'image' => 'berlin3t.jpg', 'href' => '#');
		
		return $this->render('home/layout.html.twig', array('page'=> 'home','pageInfo' => $pageInfo, 'products' => $products,'privates' => $privates));
    }
	
	public function userTranslation($lang,$page)
    {    
        $this->session->set('_locale', $lang);
        return $this->redirectToRoute($page);
    }
}