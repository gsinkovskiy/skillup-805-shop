<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{

    /**
     * @Route("/product", name="product")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);
        $products = $repo->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/product/create", name="product_create")
     */
    public function create()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $product = new Product();
        $product->setTitle('Телевизор');
        $product->setPrice(10000);
        $product->setDescription('Большой телевизор');

        $entityManager->persist($product);
        $entityManager->flush();

        return new Response('Продукт сохранен с id ' . $product->getId());

        /*
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]); */
    }

    /**
     * @Route("/product/{id}", name="product_show")
     */
    public function showAction(Product $product)
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/product/{id}/edit", name="product_edit")
     */
    public function edit(Product $product)
    {
        $product->setPrice($product->getPrice() + 10);
        $this->getDoctrine()->getManager()->flush();

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/product/{id}/delete", name="product_delete")
     */
    public function delete(Product $product)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('product');
    }

}
