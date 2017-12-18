<?php


namespace App\Service;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Menu
{
	private $factory;

	/**
	 * @param FactoryInterface $factory
	 */
	public function __construct(FactoryInterface $factory)
	{
		$this->factory = $factory;
	}

	public function createMainMenu(RequestStack $requestStack)
	{
		$menu = $this->factory->createItem('root');

		$menu->addChild('Home', array('route' => 'page', 'slug' => ''));
		$menu->addChild('About Us', array('route' => 'page', 'slug' => 'about'));
		$menu->addChild('Catalogue', array('route' => 'categories'));
		//$menu->addChild('Contacts', array('route' => 'contacts'));

		return $menu;
	}
}