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

		$menu->addChild('Главная', array('route' => 'home'))->setAttributes(['class' => 'nav-item']);
		$menu->addChild('Доставка и Оплата', array('route' => 'about'));
		$categoriesMenu = $menu->addChild('Каталог', array('route' => 'categories'));
		$menu->addChild('Контакты', array('route' => 'contacts'));
		$categoriesMenu->setExtra('dropdown', true);

		foreach($this->catalogueService->getTopCategories() as $category) {
			$categoriesMenu->addChild($category->getName(), [
				'route' => 'category_show',
				'routeParameters' => ['slug' => $category->getSlug()],
			]);
		}

		return $menu;
	}
}