<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


class CategoryController extends Controller
{

	/**
	 * @Route("/category/{slug}/{page}", name="category_show", requirements={"page": "\d+"})
	 *
	 * @param $slug
	 * @param $page
	 * @param $session
	 *
	 * @return Response
	 */
	public function show($slug, SessionInterface $session, Request $request, $page = 1 )
	{
		$session->set('lastVisitedCategory', $slug);
		$param = $request->query->get('param');

		return $this->render('category/show.html.twig',
			['slug' => $slug,
			 'title' => "category title",
			 'h1' => 'category Name',
			 'param' => $param,
			 'page' => $page]);
	}

	/**
	 * @Route("/message", name="category_message")
	 */
	public function message(SessionInterface $session)
	{
		$this->addFlash('notice', 'Your Message in category');
		$last_visit = $session->get('lastVisitedCategory');
		return $this->redirectToRoute('category_show', ['slug' => $last_visit]);
	}
}