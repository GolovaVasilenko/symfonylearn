<?php


namespace App\Controller;

use App\Entity\FeedBack;
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

class PageController extends Controller {
	/**
	 * @Route("/", name="home")
	 *
	 * @param StaticPage $sp
	 * @param Catalogue $catalogue
	 *
	 * @return Response
	 */
	public function getPage( StaticPage $sp, Catalogue $catalogue ) {

		$products = $catalogue->getProducts();

		$page = $sp->getPage( 'home' );

		if ( ! $page ) {
			throw new NotFoundHttpException( "ERROR 404 Page Not Found!" );
		}

		return $this->render( 'page/index.html.twig', [
			'page'     => $page,
			'products' => $products
		] );
	}

	/**
	 * @Route("/about", name="about")
	 * @param StaticPage $sp
	 *
	 * @return Response
	 */
	public function about( StaticPage $sp ) {
		$page = $sp->getPage( 'about' );

		if ( ! $page ) {
			throw new NotFoundHttpException( "ERROR 404 Page Not Found!" );
		}
		return $this->render( 'page/page.html.twig', [
			'page' => $page,
		] );
	}

	/**
	 * @Route("/contacts", name="contacts")
	 * @param StaticPage $sp
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function contacts( StaticPage $sp, Request $request, EntityManagerInterface $em, \Swift_Mailer $mailer ) {
		$page = $sp->getPage( 'contacts' );

		$feedback = new FeedBack();

		$form = $this->createForm( FeedBackType::class, $feedback );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$em->persist( $feedback );
			$em->flush();
			$this->addFlash( 'info', "Спасибо за сообщение!" );

			$message = ( new \Swift_Message( 'Сообщение с сайта Super Mayka' ) )
				->setFrom( [ getenv( 'MAILER_FROM' ) => getenv( 'MAILER_FROM_NAME' ) ] )
				->setTo( getenv( 'ADMIN_EMAIL' ) )
				->setBody(
					$this->renderView(
					// templates/emails/registration.html.twig
						'email/feedback.html.twig',
						array( 'feedback' => $feedback )
					),
					'text/html'
				);
			$mailer->send( $message );

			return $this->redirectToRoute( 'contacts' );
		}

		if ( ! $page ) {
			throw new NotFoundHttpException( "ERROR 404 Page Not Found!" );
		}
		return $this->render( 'page/feedback.html.twig', [
			'page' => $page,
			'form' => $form->createView(),
		] );
	}

}