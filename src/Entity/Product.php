<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
    private $name;

	/**
	 * @ORM\Column(type="decimal", scale=2, nullable=true)
	 */
    private $price;

	/**
	 * @ORM\Column(type="text")
	 */
    private $description;

	/**
	 * @var Category
	 * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
	 * @ORM\JoinColumn(name="category_id", onDelete="CASCADE")
	 */
    private $category;

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param mixed $id
	 *
	 * @return Product
	 */
	public function setId( $id ) {
		$this->id = $id;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param mixed $name
	 *
	 * @return Product
	 */
	public function setName( $name ) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPrice() {
		return $this->price;
	}

	/**
	 * @param mixed $price
	 *
	 * @return Product
	 */
	public function setPrice( $price ) {
		$this->price = $price;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param mixed $description
	 *
	 * @return Product
	 */
	public function setDescription( $description ) {
		$this->description = $description;
		return $this;
	}

	/**
	 * @return Category
	 */
	public function getCategory(): Category {
		return $this->category;
	}

	/**
	 * @param Category $category
	 */
	public function setCategory( Category $category ): void {
		$this->category = $category;
	}


}
