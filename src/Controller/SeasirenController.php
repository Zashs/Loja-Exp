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
		$privates[] = array('desc' => $translator->trans('home.private.title_list.kids_party'), 'image' => 'berlin1t.jpg', 'href' => 'kids_birthday_party');
		$privates[] = array('desc' => $translator->trans('home.private.title_list.private_tour'), 'image' => 'berlin2t.jpg', 'href' => 'seasiren_private_tour');
		$privates[] = array('desc' => $translator->trans('home.private.title_list.marrige_wedding'), 'image' => 'berlin3t.jpg', 'href' => 'marrige_proposal_wedding_photoshoot');
		$privates[] = array('desc' => $translator->trans('home.private.title_list.team_building'), 'image' => 'berlin1t.jpg', 'href' => 'team_building_activity');
		$privates[] = array('desc' => $translator->trans('home.private.title_list.gift_voucher'), 'image' => 'berlin2t.jpg', 'href' => 'gift_voucher');
		$privates[] = array('desc' => $translator->trans('home.private.title_list.photografy'), 'image' => 'berlin3t.jpg', 'href' => 'private_photography_tour');
		
		return $this->render('home/layout.html.twig', array('page'=> 'home','pageInfo' => $pageInfo, 'products' => $products,'privates' => $privates));
    }
	
	public function pageDetail(Request $request, $page, $pageSub, TranslatorInterface $translator)
    {
		$request = $request->getlocale();
		
		$pageInfo = array();
		$pageInfo = array('title'=> $translator->trans('home.title'), 'sub_title' => $translator->trans('home.sub_title'), 'text' => $translator->trans('home.text'));
		
		$pageDesc = array();
		if($pageSub == 'about_us' || $pageSub == 'contacts')
		{
			$pageDesc = array(
				'title' => $translator->trans('page_detail.'.$pageSub.'.title'),
				'sub_title' => $translator->trans('page_detail.'.$pageSub.'.sub_title'),
				'text_list' => array()
			);
			for($i = 0; $i < 15; $i++)
			{
				$locale = $translator->getLocale();
				$catalogue = $translator->getCatalogue($locale);
				$id = 'page_detail.'.$pageSub.'.text_list.text_'.($i+1);
				if ($catalogue->defines($id))
				{
					$pageDesc['text_list'][] = array('text' => $translator->trans('page_detail.'.$pageSub.'.text_list.text_'.($i+1)));
				}
				else
				{
					break;
				}
			}
			if($pageSub == 'contacts')
			{
				$pageDesc['form'] = array(
										'name' => $translator->trans('page_detail.'.$pageSub.'.form.name'),
										'email' => $translator->trans('page_detail.'.$pageSub.'.form.email'),
										'message' => $translator->trans('page_detail.'.$pageSub.'.form.message'),
										'send' => $translator->trans('page_detail.'.$pageSub.'.form.send')
									);
			}
		}
		else
		{
			$pageDesc = array(
				'title' => $translator->trans('page_detail.boats.'.$pageSub.'.title'),
				'sub_title' => $translator->trans('page_detail.boats.'.$pageSub.'.sub_title'),
				'text_list' => array()
			);
			for($i = 0; $i < 15; $i++)
			{
				$locale = $translator->getLocale();
				$catalogue = $translator->getCatalogue($locale);
				$id = 'page_detail.boats.'.$pageSub.'.text_list.text_'.($i+1);
				if ($catalogue->defines($id))
				{
					$pageDesc['text_list'][] = array('text' => $translator->trans('page_detail.boats.'.$pageSub.'.text_list.text_'.($i+1)));
				}
				else
				{
					break;
				}
			}
		}
		
		return $this->render('home/page_detail.html.twig', array('page'=> $page, 'pageSub'=> $pageSub, 'pageInfo' => $pageInfo, 'pageDesc' => $pageDesc));
	}
	
	public function productDetail(Request $request, $page, $pageSub, TranslatorInterface $translator)
    {
		$request = $request->getlocale();
		
		$pageInfo = array();
		$pageInfo = array('title'=> $translator->trans('home.title'), 'sub_title' => $translator->trans('home.sub_title'), 'text' => $translator->trans('home.text'));
		
		$pageDesc = array(
				'text_list' => array(),
				'add_info' => array(
					'title' => $translator->trans('product_detail.'.$pageSub.'.add_info.title'),
					'text_list' => array()
				)
			);
		
		for($i = 0; $i < 15; $i++)
		{
			$locale = $translator->getLocale();
			$catalogue = $translator->getCatalogue($locale);
			$id1 = 'product_detail.'.$pageSub.'.text_list.text_'.($i+1);
			$id2 = 'product_detail.'.$pageSub.'.add_info.text_list.text_'.($i+1);
			if ($catalogue->defines($id1))
				array_push($pageDesc['text_list'],['text' => $translator->trans('product_detail.'.$pageSub.'.text_list.text_'.($i+1))]);
			if ($catalogue->defines($id2))
				array_push($pageDesc['add_info']['text_list'],['text' => $translator->trans('product_detail.'.$pageSub.'.add_info.text_list.text_'.($i+1))]);
		}
		$arrayAux = array();
		$arrayAux = array(
			'title' => $translator->trans('product_detail.'.$pageSub.'.title'),
			'price' => $translator->trans('product_detail.'.$pageSub.'.price'),
			'book' => $translator->trans('product_detail.'.$pageSub.'.book'),
			'pdf_info' => array(
				'title' => $translator->trans('product_detail.'.$pageSub.'.pdf_info.title'),
				'text_1' => $translator->trans('product_detail.'.$pageSub.'.pdf_info.text_1'),
				'link' => $translator->trans('product_detail.'.$pageSub.'.pdf_info.link')
			),
			'cancel_pol' => array(
				'title' => $translator->trans('product_detail.'.$pageSub.'.cancel_pol.title'),
				'text_list' => array(
					'text_1' => $translator->trans('product_detail.'.$pageSub.'.cancel_pol.text_list.text_1'),
					'text_2' => $translator->trans('product_detail.'.$pageSub.'.cancel_pol.text_list.text_2'),
					'text_3' => $translator->trans('product_detail.'.$pageSub.'.cancel_pol.text_list.text_3')
				)
			)
		);
		$pageDesc =array_merge($pageDesc,$arrayAux);
		
		return $this->render('home/product_detail.html.twig', array('page'=> $page, 'pageSub'=> $pageSub, 'pageInfo' => $pageInfo, 'pageDesc' => $pageDesc));
	}
	
	public function privateDetail(Request $request, $page, $pageSub, TranslatorInterface $translator)
    {
		$request = $request->getlocale();
		
		$pageInfo = array();
		$pageInfo = array('title'=> $translator->trans('home.title'), 'sub_title' => $translator->trans('home.sub_title'), 'text' => $translator->trans('home.text'));
		
		if($pageSub == 'gift_voucher')
		{
			$pageDesc = array(
				'title' => $translator->trans('private_detail.'.$pageSub.'.title'),
				'text_list' => array(
					'text_1' => $translator->trans('private_detail.'.$pageSub.'.text_list.text_1'),
					'text_2' => $translator->trans('private_detail.'.$pageSub.'.text_list.text_2'),
					'text_3' => $translator->trans('private_detail.'.$pageSub.'.text_list.text_3'),
				),
				'payer' => array(
					'title' => $translator->trans('private_detail.'.$pageSub.'.text_list.payer.title'),
					'name' => $translator->trans('private_detail.'.$pageSub.'.text_list.payer.name'),
					'surname' => $translator->trans('private_detail.'.$pageSub.'.text_list.payer.surname'),
					'email' => $translator->trans('private_detail.'.$pageSub.'.text_list.payer.email'),
					'telephone' => $translator->trans('private_detail.'.$pageSub.'.text_list.payer.telephone'),
					'persons' => $translator->trans('private_detail.'.$pageSub.'.text_list.payer.persons'),
					'experiences_title' => $translator->trans('private_detail.'.$pageSub.'.text_list.payer.experiences_title'),
					'experiences' => array(
						'1' => $translator->trans('private_detail.'.$pageSub.'.text_list.payer.experiences.1'),
						'2' => $translator->trans('private_detail.'.$pageSub.'.text_list.payer.experiences.2'),
						'3' => $translator->trans('private_detail.'.$pageSub.'.text_list.payer.experiences.3'),
						'4' => $translator->trans('private_detail.'.$pageSub.'.text_list.payer.experiences.4'),
						'5' => $translator->trans('private_detail.'.$pageSub.'.text_list.payer.experiences.5'),
						'6' => $translator->trans('private_detail.'.$pageSub.'.text_list.payer.experiences.6'),
						'7' => $translator->trans('private_detail.'.$pageSub.'.text_list.payer.experiences.7'),
						'8' => $translator->trans('private_detail.'.$pageSub.'.text_list.payer.experiences.8'),
						'9' => $translator->trans('private_detail.'.$pageSub.'.text_list.payer.experiences.9'),
					),
				),
				'destiny' => array(
					'title' => $translator->trans('private_detail.'.$pageSub.'.text_list.destiny.title'),
					'name' => $translator->trans('private_detail.'.$pageSub.'.text_list.destiny.name'),
					'surname' => $translator->trans('private_detail.'.$pageSub.'.text_list.destiny.surname'),
					'email' => $translator->trans('private_detail.'.$pageSub.'.text_list.destiny.email'),
					'telephone' => $translator->trans('private_detail.'.$pageSub.'.text_list.destiny.telephone')
				),
			);
			
		}
		else
		{
			$pageDesc = array(
				'title' => $translator->trans('private_detail.'.$pageSub.'.title'),
				'text_list' => array()
			);
			
			for($i = 0; $i < 15; $i++)
			{
				$locale = $translator->getLocale();
				$catalogue = $translator->getCatalogue($locale);
				$id1 = 'private_detail.'.$pageSub.'.text_list.text_'.($i+1);
				if ($catalogue->defines($id1))
					array_push($pageDesc['text_list'],['text' => $translator->trans('private_detail.'.$pageSub.'.text_list.text_'.($i+1))]);
			}
			
			if($pageSub == 'private_photography_tour')
			{
				$arrayAux = array();
				$arrayAux = array(
					'commemtary' => array(
						'text' => $translator->trans('private_detail.'.$pageSub.'.commemtary.text'),
						'author' => $translator->trans('private_detail.'.$pageSub.'.commemtary.author')
					)
				);
				
				$pageDesc = array_merge($pageDesc,$arrayAux);
			}
		}
		
		return $this->render('home/private_detail.html.twig', array('page'=> $page, 'pageSub'=> $pageSub, 'pageInfo' => $pageInfo, 'pageDesc' => $pageDesc));
	}
	
	public function userTranslation($lang,$page,$pageSub)
    {    
        $this->session->set('_locale', $lang);
		if($pageSub == ' ')
		{
			return $this->redirectToRoute($page);
		}
		else
		{
			return $this->redirectToRoute($page,array('page'=>$page, 'pageSub' => $pageSub ));
		}
    }
}