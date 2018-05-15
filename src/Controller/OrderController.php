<?php

namespace App\Controller;

use App\Entity\OrderItem;
use App\Entity\Product;
use App\Service\Orders;
use http\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OrderController extends Controller
{
    /**
     * @Route("/cart/add/{id}/{quantity}", name="order_add_to_cart")
     */
    public function addToCart(
        Orders $orders,
        Request $request,
        Product $product,
        $quantity = 1
    ) {
        $orders->addToCart($product, $quantity, $this->getUser());

        if ($request->isXmlHttpRequest()) {
            return $this->render('order/header_cart.html.twig', [
                'cart' => $orders->getCart(),
            ]);
        }

        return $this->redirect($request->headers->get('referer', '/'));
    }

    /**
     * @Route("/cart", name="order_cart")
     */
    public function cart(Orders $orders)
    {
        $cart = $orders->getCart($this->getUser());

        return $this->render('order/cart.html.twig', [
            'cart' => $cart,
        ]);
    }

    /**
     * @Route("/cart/header", name="order_header_cart")
     */
    public function headerCart(Orders $orders)
    {
        return $this->render('order/header_cart.html.twig', [
            'cart' => $orders->getCart(),
        ]);
    }

    /**
     * @Route("/cart/delete/{id}", name="order_remove_from_cart")
     */
    public function removeFromCart(Orders $orders, OrderItem $item)
    {
        $cart = $orders->removeFromCart($item);

        return $this->render('order/cart_table.html.twig', [
            'cart' => $cart,
        ]);
    }

    /**
     * @Route("/cart/update/{id}/{quantity}", name="order_update_cart_item_quantity")
     */
    public function updateCartItemQuantity(Orders $orders, OrderItem $item, $quantity)
    {
        $quantity = (int)$quantity;

        if ($quantity < 1) {
            $quantity = $item->getQuantity();
        }

        $cart = $orders->updateCartItemQuantity($item, $quantity);

        return $this->render('order/cart_table.html.twig', [
            'cart' => $cart,
        ]);
    }

}
