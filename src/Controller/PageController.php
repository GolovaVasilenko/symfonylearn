<?php


namespace App\Controller;

use App\Entity\Page;
use App\Service\Catalogue;
use App\Service\StaticPage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
	 * @return Response
	 */
	public function contacts(StaticPage $sp)
	{
		$page = $sp->getPage('contacts');

		if(!$page){
			throw new NotFoundHttpException("ERROR 404 Page Not Found!");
		}
		return $this->render('page/page.html.twig', [
			'page' => $page,
		]);
	}


	/*public function redirectToShow()
	{
		return $this->redirectToRoute('home');
	}*/
}