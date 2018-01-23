<?php


namespace App\Admin;


use App\Entity\Order;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OrderAdmin extends AbstractAdmin
{
	/**
	 * @param FormMapper $formMapper
	 *
	 */
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
			//->add('user')
			->add('customerName')
			->add('status', ChoiceType::class, [
				'choices' => [
					'draft'     => Order::STATUS_DRAFT,
					'ordered'   => Order::STATUS_ORDER,
					'sent'      => Order::STATUS_SEND,
					'received'  => Order::STATUS_RESEIVED,
					'completed' => Order::STATUS_COMPLETED,
				]
			])
			->add('email')
			->add('phone')
			->add('address')
			->add('count')
			->add('amount')
			->add('isPaid')
			->add('createdAt')
		;
	}

	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('customerName')
			->add('email')
			->add('phone')
			->add('status', null, [], ChoiceType::class, [
				'choices' => [
					'draft'     => Order::STATUS_DRAFT,
					'ordered'   => Order::STATUS_ORDER,
					'sent'      => Order::STATUS_SEND,
					'received'  => Order::STATUS_RESEIVED,
					'completed' => Order::STATUS_COMPLETED,
				]
			])
			->add('address');
	}

	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->add('ID')
			->addIdentifier('createdAt')
			//->add('user')
			//->add('customerName')
			->addIdentifier('email')
			->add('status', 'choice', [
				'editable' => true,
				'choices' => [
					Order::STATUS_DRAFT     => 'draft',
					Order::STATUS_ORDER     => 'ordered',
					Order::STATUS_SEND      => 'sent',
					Order::STATUS_RESEIVED  => 'received',
					Order::STATUS_COMPLETED => 'completed',
				],
				'catalogue' => 'messages'
			])
			->add('phone')
			->add('isPaid', null, ['editable' => true]);
	}

	public function configureTabMenu( MenuItemInterface $menu, $action, AdminInterface $childAdmin = null )
	{

		if (!$childAdmin && !in_array($action, ['edit', 'show'])) {
			return;
		}

		$admin = $this->isChild() ? $this->getParent() : $this;
		$id = $admin->getRequest()->get('id');

		if ($this->isGranted('EDIT')) {
			$menu->addChild('Edit Order', [
				'uri' => $admin->generateUrl('edit', ['id' => $id])
			]);
		}

		if ($this->isGranted('LIST')) {
			$menu->addChild('Manage Items', [
				'uri' => $admin->generateUrl('admin.order_item.list', ['id' => $id])
			]);
		}
	}
}