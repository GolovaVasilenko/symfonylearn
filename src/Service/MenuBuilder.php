<?php


namespace App\Service;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuBuilder
{
	private $factory;

	private $catalogueService;

	/**
	 * @param FactoryInterface $factory
	 */
	public function __construct(FactoryInterface $factory, Catalogue $catalogue)
	{
		$this->factory = $factory;
		$this->catalogueService = $catalogue;
	}

	public function createMainMenu(array $options)
	{
		$menu = $this->factory->createItem('root');

		$menu->addChild('Home', array('route' => 'home'))->setAttributes(['class' => 'nav-item']);
		$menu->addChild('About Us', array('route' => 'about'));
		$categoriesMenu = $menu->addChild('Catalogue', array('route' => 'categories'));
		$menu->addChild('Contacts', array('route' => 'contacts'));
		$categoriesMenu->setExtra('dropdown', true);

		foreach($this->catalogueService->getTopCategories() as $category) {
			$categoriesMenu->addChild($category->getName(), [
				'route' => 'category',
				'routeParameters' => ['slug' => $category->getSlug()],
			]);
		}

		return $menu;
	}
}