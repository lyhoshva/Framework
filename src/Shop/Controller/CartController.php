<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 26.11.16
 * Time: 18:43
 */

namespace Shop\Controller;

use Framework\Controller\Controller;
use Framework\DI\Service;
use Framework\Exception\HttpNotFoundException;
use Framework\Response\Response;
use Shop\Model\Cart;
use Shop\Model\Product;

class CartController extends Controller
{
    public function addAction($id)
    {
        $product = $this->findProduct($id);
        $cart = new Cart();
        $session = Service::get('session');

        if ($cart->addProduct($product)) {
            $session->addFlush('success', 'The product successfully added');
        } else {
            $session->addFlush('info', 'The product is already in the cart');
        }

        return $this->redirect($this->generateRoute('product', ['id' => $product->getId()]));
    }

    public function previewAction()
    {
        $cart = new Cart();

        return $this->renderPartial('preview', [
            'cart' => $cart,
        ]);
    }

    public function listAction()
    {
        $cart = new Cart();
        $products = $cart->getOrderedProducts();

        return $this->render('list', [
            'cart' => $cart,
            'products' => $products,
        ]);
    }

    public function deleteAction($id)
    {
        $product = $this->findProduct($id);
        $cart = new Cart();

        $cart->deleteProduct($product);
        Service::get('session')->addFlush('info', 'Product "' . $product->getTitle() . '"" removed from cart');

        return $this->redirect($this->generateRoute('cart_list'));
    }

    public function setProductCountAction($id, $count)
    {
        $product = $this->findProduct($id);
        $cart = new Cart();

        $cart->setProductCount($product, $count);
        Service::get('app')->response_format = Response::FORMAT_JSON;

        return [
            'product_price' => $cart->getProductPrice($product),
            'total_price' => $cart->getTotalPrice(),
        ];
    }

    public function clearAction()
    {
        $cart = new Cart();
        $cart->clear();
        $session = Service::get('session');
        $session->addFlush('success', 'The cart successfully cleared');

        return $this->redirect('/');
    }

    /**
     * @param $id
     * @return Product
     * @throws HttpNotFoundException
     */
    private function findProduct($id)
    {
        $product = Product::findOne($id);
        if (empty($product)) {
            throw new HttpNotFoundException();
        }

        return $product;
    }
}
