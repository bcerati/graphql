<?php
namespace App\Manager;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ProductManager
 *
 * @package APp\Manager
 */
class ProductManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this
            ->entityManager
            ->getRepository(Product::class)
            ->findAll();
    }

    public function getProduct(int $id): Product
    {
        return $this
            ->entityManager
            ->getRepository(Product::class)
            ->findOneBy(['id' => $id]);
    }
}
