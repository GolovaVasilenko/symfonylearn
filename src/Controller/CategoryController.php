<?php


namespace App\Controller;


use App\Service\Catalogue;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;


class CategoryController extends Controller
{

	/**
	 * @var Catalogue
	 */
	private $catalogue;

	/**
	 * CategoryController constructor.
	 *
	 * @param Catalogue $catalogue
	 */
	public function __construct(Catalogue $catalogue)
	{
		$this->catalogue = $catalogue;
	}

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

		$categories = $this->catalogue->getCategories();

		if(!$categories){
			throw $this->createNotFoundException('Category not found');
		}

		return $this->render('category/index.html.twig',[
			'title' => 'List Categories',
			'categories' => $categories
		]);
	}

	/**
	 * @Route("/category/{slug}/{page}", name="category_show", requirements={"page": "\d+"})
	 *
	 * @ParamConverter("slug", options={"mapping": {"slug":"slug"}})
	 *
	 * @param $page
	 * @param $session
	 * @param $slug
	 *
	 * @return Response
	 */
	public function showBySlug(SessionInterface $session, $slug, $page = 1 )
	{
		$category = $this->catalogue->getCategoryBySlug($slug);
		return $this->render('category/show.html.twig',
			['category' => $category,
			 'title' => "category title",
			 'h1' => 'category ' . $category->getName(),
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