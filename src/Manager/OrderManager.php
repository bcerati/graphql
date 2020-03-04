<?php
namespace App\Manager;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class OrderManager
 *
 * @package APp\Manager
 */
class OrderManager
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
    public function getOrders(): array
    {
        return $this
            ->entityManager
            ->getRepository(Order::class)
            ->findAll();
    }
}
