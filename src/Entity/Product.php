<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable
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
	 * @ORM\Column(type="string", length=255, unique=true)
	 */
    private $slug;

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
	 * NOTE: This is not a mapped field of entity metadata, just a simple property.
	 *
	 * @Vich\UploadableField(mapping="products", fileNameProperty="imageName", size="imageSize")
	 *
	 * @var File
	 */
	private $imageFile;

	/**
	 * @ORM\Column(type="string", length=255, options={"default": ""})
	 *
	 * @var string
	 */
	private $imageName;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 *
	 * @var integer
	 */
	private $imageSize;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $updatedAt;

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
	public function getCategory(): ? Category
	{
		return $this->category;
	}

	/**
	 * @param Category $category
	 */
	public function setCategory( Category $category ): void {
		$this->category = $category;
	}

	/**
	 * @return mixed
	 */
	public function getSlug() {
		return $this->slug;
	}

	/**
	 * @param mixed $slug
	 */
	public function setSlug( $slug ): void {
		$this->slug = $slug;
	}

	/**
	 * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
	 * of 'UploadedFile' is injected into this setter to trigger the  update. If this
	 * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
	 * must be able to accept an instance of 'File' as the bundle will inject one here
	 * during Doctrine hydration.
	 *
	 * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
	 */
	public function setImageFile(?File $image = null): void
	{
		$this->imageFile = $image;

		if (null !== $image) {
			// It is required that at least one field changes if you are using doctrine
			// otherwise the event listeners won't be called and the file is lost
			$this->updatedAt = new \DateTimeImmutable();
		}
	}

	/**
	 * @return null|File
	 */
	public function getImageFile(): ?File
	{
		return $this->imageFile;
	}

	public function setImageName(?string $imageName): void
	{
		$this->imageName = $imageName;
	}

	/**
	 * @return null|string
	 */
	public function getImageName(): ?string
	{
		return $this->imageName;
	}

	/**
	 * @param int|null $imageSize
	 */
	public function setImageSize(?int $imageSize): void
	{
		$this->imageSize = $imageSize;
	}

	/**
	 * @return int|null
	 */
	public function getImageSize(): ?int
	{
		return $this->imageSize;
	}

	/**
	 * @return mixed
	 */
	public function __toString(): string
	{
		$name = $this->getName()?$this->getName(): '';
		return $name;
	}

}
