<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller
{

    /**
     * @Route("/category", name="category")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repo->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/category/{id}", name="category_show")
     */
    public function showAction(Category $category)
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }

}
