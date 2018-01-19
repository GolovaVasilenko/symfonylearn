<?php


namespace App\Controller;


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
	 * @param $id
	 *
	 * @Route("/cart/{id}", name="show_cart")
	 *
	 * @return Response
	 */
	public function showCart($id)
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
}