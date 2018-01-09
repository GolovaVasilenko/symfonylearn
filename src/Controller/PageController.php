<?php


namespace App\Controller;

use App\Entity\Page;
use App\Form\FeedBackType;
use App\Service\Catalogue;
use App\Service\StaticPage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PageController extends Controller
{
	/**
	 * @Route("/", name="home")
	 *
	 * @param StaticPage $sp
	 * @param Catalogue $catalogue
	 * @return Response
	 */
	public function getPage(StaticPage $sp, Catalogue $catalogue)
	{

		$products = $catalogue->getProducts();

		$page = $sp->getPage('home');

		if(!$page){
			throw new NotFoundHttpException("ERROR 404 Page Not Found!");
		}

		return $this->render('page/index.html.twig', [
								'page' => $page,
								'products' => $products
		]);
	}

	/**
	 * @Route("/about", name="about")
	 * @param StaticPage $sp
	 *
	 * @return Response
	 */
	public function about(StaticPage $sp)
	{
		$page = $sp->getPage('about');

		if(!$page){
			throw new NotFoundHttpException("ERROR 404 Page Not Found!");
		}
		return $this->render('page/page.html.twig', [
			'page' => $page,
		]);
	}

	/**
	 * @Route("/contacts", name="contacts")
	 * @param StaticPage $sp
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function contacts(StaticPage $sp, Request $request)
	{
		$page = $sp->getPage('contacts');
		$form = $this->createForm(FeedBackType::class);

		if(!$page){
			throw new NotFoundHttpException("ERROR 404 Page Not Found!");
		}
		return $this->render('page/feedback.html.twig', [
			'page' => $page,
			'form' => $form->createView(),
		]);
	}


	/*public function redirectToShow()
	{
		return $this->redirectToRoute('home');
	}*/
}