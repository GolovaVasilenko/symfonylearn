<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
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
	 * @ORM\Column(type="text")
	 */
    private $description;

	/**
	 * @ORM\Column(type="string", unique=true, length=255)
	 */
    private $slug;

	/**
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="subcategory")
	 * @ORM\JoinColumn(name="parent_id", onDelete="CASCADE")
	 */
    private $parent;

	/**
	 * @var
	 *
	 * @ORM\OneToMany(targetEntity="App\Entity\Category", mappedBy="parent")
	 */
    private $subcategory;

	/**
	 * @var Product[]|ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="category")
	 */
    private $products;

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 * @return Category
	 */
	public function setId( $id )
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param mixed $name
	 * @return Category
	 */
	public function setName( $name )
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param mixed $description
	 * @return Category
	 */
	public function setDescription( $description )
	{
		$this->description = $description;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getSlug()
	{
		return $this->slug;
	}

	/**
	 * @param mixed $slug
	 * @return Category
	 */
	public function setSlug( $slug )
	{
		$this->slug = $slug;
		return $this;
	}

	/**
	 * @return Product[]|ArrayCollection
	 */
	public function getProducts():Collection
	{
		return $this->products;
	}

	public function addProduct(Product $product)
	{
		$this->products->add($product);
		$product->setCategory($this);
		return $this;
	}

	public function removeProduct(Product $product)
	{
		$this->products->removeElement($product);
		return $this;
	}


}
