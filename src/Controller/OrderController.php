<?php


namespace App\Controller;


use App\Entity\Order;
use App\Entity\OrderItem;
use App\Form\OrderType;
use App\Service\Orders;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;

class OrderController extends Controller
{

	private $order;

	public function __construct(Orders $order)
	{
		$this->order = $order;
	}

	/**
	 *
	 * @Route("/cart", name="show_cart")
	 *
	 * @return Response
	 */
	public function showCart()
	{
		$title = "Show Cart";

		return $this->render('cart/show.html.twig', [
			'title' => $title,
			'cart'  => $this->order->getCurrentOrder(),
		]);
	}

	/**
	 * @Route("cart/add/{id}/{count}", name="cart_add_product",
	 *                  requirements={"id": "\d+","count": "\d+(\.\d+)?"})
	 * @param Product $product
	 * @param $count
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function addItemToCart(Product $product, $count, Request $request)
	{
		$this->order->addProduct($product, $count);

		return $this->redirect($request->headers->get('referer'));
	}

	/**
	 * @param OrderItem $orderItem
	 * @param Request $request
	 *
	 * @Route("order/removeItem", name="remove_item")
	 *
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function removeItem(OrderItem $orderItem, Request $request)
	{
		$this->order->removeItem($orderItem);

		return $this->redirect($request->headers->get('referer'));
	}

	/**
	 * @param Request $request
	 *
	 * @return Response
	 *
	 * @Route("order/complete", name="complete_order" )
	 */
	public function completeOrder(Request $request, \Swift_Mailer $mailer)
	{
		$order = $this->order->getCurrentOrder();
		$form = $this->createForm(OrderType::class, $order);

		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){
			$this->sendEmails($order, $mailer);
			$this->order->makeOrder($order);
			return $this->redirectToRoute('success_order');
		}

		return $this->render('order/completeForm.html.twig', [
			'cart' => $order,
			'form'  => $form->createView(),
		]);
	}

	/**
	 * @return Response
	 * @param Orders $order
	 * @Route("order/success", name="success_order")
	 */
	public function successOrder(Orders $order)
	{
		return $this->render('order/success.html.twig', ['order' => $order]);
	}

	/**
	 * @param Order $order
	 * @param \Swift_Mailer $mailer
	 */
	public function sendEmails(Order $order, \Swift_Mailer $mailer)
	{

		$message = ( new \Swift_Message( 'Новый Заказ на сайте' ) )
			->setFrom( [ getenv( 'MAILER_FROM' ) => getenv( 'MAILER_FROM_NAME' ) ] )
			->setTo( getenv( 'ADMIN_EMAIL' ) )
			->setBody(
				$this->renderView(
					'email/admin_message.html.twig',
					array( 'order' => $order )
				),
				'text/html'
			);
		$mailer->send( $message );

		$message = ( new \Swift_Message( 'Ваш заказ' ) )
			->setFrom( [ getenv( 'MAILER_FROM' ) => getenv( 'MAILER_FROM_NAME' ) ] )
			->setTo( [$order->getEmail() => $order->getCustomerName()] )
			->setBody(
				$this->renderView(
					'email/customer_message.html.twig',
					array( 'order' => $order )
				),
				'text/html'
			);
		$mailer->send( $message );
	}
}