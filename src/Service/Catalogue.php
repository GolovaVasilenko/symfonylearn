<?php


namespace App\Service;


use App\Entity\Category;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class Catalogue
{
	/***
	 * @var EntityManagerInterface
	 */
	private $em;

	/**
	 * Catalogue constructor.
	 *
	 * @param EntityManagerInterface $entityManager
	 */
	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->em = $entityManager;
	}

	/**
	 * @return Category[]|array
	 */
	public function getCategories()
	{
		$repo = $this->em->getRepository(Category::class);
		return $repo->findAll();
	}

	public function getProducts()
	{
		$repo = $this->em->getRepository(Product::class);
		return $repo->findAll();
	}

}