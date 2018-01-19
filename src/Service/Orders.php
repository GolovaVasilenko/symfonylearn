<?php


namespace App\Service;


use App\Entity\Order;
use App\Entity\OrderItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Product;

class Orders {

	/**
	 * @var EntityManagerInterface
	 */
	private $em;

	/**
	 * @var SessionInterface
	 */
	private $session;

	/**
	 * Order constructor.
	 *
	 * @param EntityManagerInterface $em
	 * @param SessionInterface $session
	 */
	public function __construct(EntityManagerInterface $em, SessionInterface $session)
	{
		$this->em = $em;
		$this->session = $session;
	}

	/**
	 * @return Order
	 */
	public function getCurrentOrder(): Order
	{
		$repo = $this->em->getRepository(Order::class);

		$id = $this->session->get('current_order_id');

		$order = $id ? $repo->find($id) : null;

		if(!$order || $order->getStatus() != Order::STATUS_DRAFT){
			$order = new Order();
			$this->em->persist($order);
			$this->em->flush();
			$this->session->set('current_order_id', $order);
			$this->session->remove('current_order_id');
		}

		return $order;
	}

	/**
	 * @param Product $product
	 * @param $count
	 */
	public function addProduct(Product $product, $count)
	{
		$order = $this->getCurrentOrder();

		$existingItem = null;
		$items = $order->getItems();

		if($items){
			foreach($items as $item) {
				if($item->getProduct()->getId() == $product->getId()) {
					$existingItem = $item;
					break;
				}
			}
		}


		if(!$existingItem) {
			$existingItem = new OrderItem();
			$existingItem->setProduct($product);
			$order->addItem($existingItem);
			$this->em->persist($existingItem);
		}

		$existingItem->addCount($count);
		$this->em->flush();
	}

	public function makeOrder(Order $order)
	{
		$order->setStatus(Order::STATUS_COMPLETED);
		$this->em->flush();
	}

}