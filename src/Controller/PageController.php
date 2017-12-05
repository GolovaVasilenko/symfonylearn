<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PageController extends Controller
{
	/**
	 * @Route("/", name="home")
	 *
	 * @return mixed
	 */
	public function home()
	{
		$data['title'] = "Home page";
		$data['h1'] = "Home page Welcome to my site";
		$data['body'] = "lorem  ipsum Давно выяснено, что при оценке дизайна и композиции 
		читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот 
		обеспечивает более или менее стандартное заполнение шаблона, а также реальное 
		распределение букв и пробелов в абзацах, которое не получается при простой 
		дубликации Здесь ваш текст.. Здесь ваш текст.";
		return $this->render('page/home.html.twig', $data);
	}

	/**
	 * @Route("/about", name="about")
	 *
	 * @return mixed
	 */
	public function about(SessionInterface $session)
	{
		$data['title'] = "About Us page";
		$data['h1'] = "About my super Shop Info";
		$data['last_visit'] = $session->get('lastVisitedCategory');
		$data['link'] = $this->generateUrl('category_show', ['slug' => 'notebook', 'param' => 'ddd'], UrlGeneratorInterface::ABSOLUTE_URL);
		$data['body'] = "Lorem Ipsum - это текст-\"рыба\", часто используемый в печати и 
		вэб-дизайне. Lorem Ipsum является стандартной \"рыбой\" для текстов на латинице с 
		начала XVI века. В то время некий безымянный печатник создал большую коллекцию 
		размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum 
		не только успешно пережил без заметных изменений пять веков, но и перешагнул в 
		электронный дизайн. Его популяризации в новое время послужили публикация листов 
		Letraset с образцами Lorem Ipsum в 60-х годах и, в более недавнее время, программы 
		электронной вёрстки типа Aldus PageMaker, в шаблонах которых используется Lorem Ipsum.";
		return $this->render('page/about.html.twig', $data);
	}

	/**
	 * @Route("/about-to")
	 */
	public function redirectToShow()
	{
		return $this->redirectToRoute('home');
	}
}