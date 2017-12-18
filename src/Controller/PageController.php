<?php


namespace App\Controller;

use App\Entity\Page;
use App\Service\Catalogue;
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
	 * @Route("/{slug}", name="page")
	 *
	 * @param $em
	 * @param $slug
	 * @return mixed
	 */
	public function getPage($slug = 'home', EntityManagerInterface $em, Catalogue $catalogue)
	{
		$products = [];
		$repo = $this->getDoctrine()->getRepository(Page::class);

		if('home' === $slug){
			$products = $catalogue->getProducts();
		}

		$page = $repo->findOneBy(['slug' => $slug]);

		if(!$page){
			throw new NotFoundHttpException("ERROR 404 Page Not Found!");
		}

		return $this->render('page/index.html.twig', [
								'page' => $page,
								'products' => $products
		]);
	}

	/**
	 * @Route("/about-to")
	 */
	public function redirectToShow()
	{
		return $this->redirectToRoute('home');
	}
}