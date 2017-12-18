<?php


namespace App\Service;

use App\Entity\Page;
use Doctrine\ORM\EntityManagerInterface;

class StaticPage
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
	 * @param $slug
	 *
	 * @return Page|null|object
	 */
	public function getPage($slug)
	{
		$repo = $this->em->getRepository(Page::class);
		return $repo->findOneBy(['slug' => $slug]);
	}
}