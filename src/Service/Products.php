<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class Products
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * Products constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getTopProducts()
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository(Product::class);

        return $repo->findBy(['isTop' => true]);
    }

}
