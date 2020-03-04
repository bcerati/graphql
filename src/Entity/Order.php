<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Order
 *
 * @package App\Entity
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity()
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="creation_date")
     */
    protected $creationDate;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    protected $amount;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $username;

    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="Product")
     */
    protected $products = [];

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Order
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate(): \DateTime
    {
        return $this->creationDate;
    }

    /**
     * @param \DateTime $creationDate
     * @return Order
     */
    public function setCreationDate(\DateTime $creationDate): Order
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return Order
     */
    public function setAmount(float $amount): Order
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return Order
     */
    public function setUsername(string $username): Order
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param array $products
     * @return Order
     */
    public function setProducts(array $products): Order
    {
        $this->products = $products;

        return $this;
    }
}
