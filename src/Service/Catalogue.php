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

	/**
	 * @param $slug
	 *
	 * @return Category|null|object
	 */
	public function getCategoryBySlug($slug)
	{
		$repo = $this->em->getRepository(Category::class);
		return $repo->findOneBy(['slug' => $slug]);
	}

	/**
	 * @return Category[]|Product[]|array
	 */
	public function getProducts()
	{
		$repo = $this->em->getRepository(Product::class);
		return $repo->findAll();
	}

	/**
	 * @return Category[]|array
	 */
	public function getTopCategories()
	{
		$repo = $this->em->getRepository(Category::class);

		return $repo->findBy(['parent' => null], ['name' => 'ASC']);
	}
}