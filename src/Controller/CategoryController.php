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
        //$categories = $repo->findBy(['parent' => null]);

        $qb = $repo->createQueryBuilder('cat');
        $qb
            ->select('cat')
            ->where('cat.parent IS NULL')
        ;
        $categories = $qb->getQuery()->execute();

        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/category/{id}", name="category_show")
     */
    public function show($id)
    {
        $repo = $this->getDoctrine()->getRepository(Category::class);
        $qb = $repo->createQueryBuilder('cat');
        $qb
            ->leftJoin('cat.subcategories', 'subcat')
            ->leftJoin('cat.products', 'p')
            ->select('cat, subcat, p')
            ->where('cat.id = :id')
            ->setParameter('id', $id)
        ;

        $category = $qb->getQuery()->getOneOrNullResult();

        if (!$category) {
            throw $this->createNotFoundException('Category with id #' . $id . ' not found.');
        }

        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }

}
