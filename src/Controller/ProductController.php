<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\Catalogue;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class ProductController extends Controller
{

    /**
     * @Route("/product", name="product")
     */
    public function index(EntityManagerInterface $em)
    {
        $product = new Product();
        $product->setName("Notebook")
                ->setPrice(8976.89)
                ->setDescription("Description for product Notebook");

        $em->persist($product);
        $em->flush();

        return new Response("New Product Created");
    }

	/**
	 * @Route("/product-show/{id}", name="product_show")
	 */
    public function show($id)
    {
    	$repo = $this->getDoctrine()->getRepository(Product::class);
    	$product = $repo->find($id);

    	if(!$product){
		    throw $this->createNotFoundException('Product not found');
	    }

	    return $this->render('product/show.html.twig', ['product' => $product, 'title' => 'new product']);
    }

    /**
	 * @Route("/product-show-by-name/{slug}", name="product_show_by_name")
     *
     * @param $slug
     *
     * @return mixed
	 */
	public function showByName($slug)
	{
		$repo = $this->getDoctrine()->getRepository(Product::class);
		$product = $repo->findOneBy(['slug' => $slug]);

		if(!$product){
			throw $this->createNotFoundException('Product not found');
		}

		return $this->render('product/show.html.twig', ['product' => $product, 'title' => 'new product']);
	}

	/**
	 * @Route("/products", name="products_list")
	 *
	 * @param Catalogue $catalogue
	 *
	 * @return Response
	 */
	public function listProduct(Catalogue $catalogue)
	{
		$products = $catalogue->getProducts();

		if(!$products){
			throw $this->createNotFoundException('Products not found');
		}

		return $this->render('product/list.html.twig',
			['products' => $products, 'title' => 'list products']);
	}

	/**
	 * @Route("/product/update/{id}", name="product_update")
	 */
	public function update(Product $product, EntityManagerInterface $em)
	{
		$product->setPrice(12453.99);

		$em->persist($product);
		$em->flush();

		return new Response("Product Updated");

	}

	/**
	 * @Route("/product/delete/{id}", name="delete_product")
	 */
	public function delete(Product $product, EntityManagerInterface $em)
	{
		$em->remove($product);
		$em->flush();

		return new Response("Product Deleted");
	}

}
