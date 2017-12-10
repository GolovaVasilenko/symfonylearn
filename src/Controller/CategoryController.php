<?php


namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;


class CategoryController extends Controller
{

	/**
	 * @Route("/category/{id}", name="category_show_by_id", requirements={"id": "\d+"})
	 * @param $id
	 * @return Response
	 */
	public function showById($id = 1, EntityManagerInterface $em)
	{
		$repo = $this->getDoctrine()->getRepository(Category::class);
		$category = $repo->find($id);

		if(!$category){
			throw $this->createNotFoundException('Category not found');
		}

		return $this->render('category/one.html.twig', [
			'category' => $category,
			'title'    => 'Category title show by id',
		]);
	}

	/**
	 * @Route("/categories", name="categories")
	 *
	 * @return Response
	 */
	public function index()
	{
		$repo = $this->getDoctrine()->getRepository(Category::class);
		$categories = $repo->findAll();
		return $this->render('category/index.html.twig',[
			'title' => 'List Categories',
			'categories' => $categories
		]);
	}

	/**
	 * @Route("/category/{slug}/{page}", name="category_show", requirements={"page": "\d+"})
	 *
	 * @param $slug
	 * @param $page
	 * @param $session
	 *
	 * @return Response
	 */
	public function showBySlug($slug, SessionInterface $session, Request $request, $page = 1 )
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