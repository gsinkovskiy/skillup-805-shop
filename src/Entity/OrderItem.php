<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_items")
 */
class OrderItem
{

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Order
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="items")
     * @ORM\JoinColumn()
     */
    private $order;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="orderItems")
     * @ORM\JoinColumn()
     */
    private $product;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", precision=10, scale=2, options={"default": 0})
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", precision=10, scale=2, options={"default": 0})
     */
    private $amount;

    public function __construct()
    {
        $this->quantity = 0;
        $this->price = 0;
        $this->amount = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        $this->updateAmount();

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;
        $this->updateAmount();

        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;
        $this->setPrice($product->getPrice());

        return $this;
    }

    private function updateAmount()
    {
        $this->amount = round($this->price * $this->quantity, 2);

        if ($this->order) {
            $this->order->updateAmount();
        }
    }

}
