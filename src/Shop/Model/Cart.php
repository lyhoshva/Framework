<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 28.11.16
 * Time: 11:56
 */

namespace Shop\Model;

use Framework\DI\Service;

class Cart
{
    protected $session;

    /**
     * Cart constructor.
     */
    public function __construct()
    {
        $this->session = Service::get('session');
    }

    /**
     * @param Product $product
     * @return bool
     */
    public function addProduct(Product $product)
    {
        $cart = $this->getCartArray();

        if (empty($cart[$product->getId()])) {
            $cart[$product->getId()] = ['count' => 1];
            $this->session->cart = $cart;

            return true;
        }

        return false;
    }

    /**
     * @param Product $product
     * @param int $count
     * @return bool
     */
    public function setProductCount(Product $product, $count)
    {
        $cart = $this->getCartArray();
        $cart[$product->getId()] = ['count' => $count];
        $this->session->cart = $cart;

        return true;
    }

    /**
     * @param Product $product
     * @return int|null
     */
    public function getProductCount(Product $product)
    {
        $cart = $this->getCartArray();

        return $cart[$product->getId()]['count'] ?? null;
    }

    /**
     * @param Product $product
     * @return int
     */
    public function getProductPrice(Product $product)
    {
        $cart = $this->getCartArray();
        return $product->getPrice() * $cart[$product->getId()]['count'];
    }

    /**
     * @return int
     */
    public function getTotalPrice()
    {
        $products = $this->getOrderedProducts();

        $totalPrice = 0;
        foreach ($products as $product) {
            $totalPrice += $this->getProductPrice($product);
        }

        return $totalPrice;
    }

    /**
     * Check whether the product is in the cart
     *
     * @param Product $product
     * @return bool
     */
    public function checkProduct(Product $product)
    {
        return !empty($this->session->cart[$product->getId()]);
    }

    /**
     * @param Product $product
     * @return bool
     */
    public function deleteProduct(Product $product)
    {
        $cart = $this->getCartArray();
        unset($cart[$product->getId()]);
        $this->session->cart = $cart;

        return true;
    }

    /**
     * @return int
     */
    public function getProductsCount()
    {
        $cart = $this->getCartArray();
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['count'];
        }

        return $count;
    }

    /**
     * @return bool
     */
    public function clear()
    {
        $this->session->cart = [];

        return true;
    }

    /**
     * @return array
     */
    public function getCartArray()
    {
        return $this->session->cart ?? [];
    }

    /**
     * @return Product[] array
     */
    public function getOrderedProducts()
    {
        $cart = $this->getCartArray();
        $product_ids = array_keys($cart);
        return Product::getRepository()->findBy(['id' => $product_ids]);
    }
}
