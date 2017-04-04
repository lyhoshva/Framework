<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 29.11.16
 * Time: 21:55
 */

namespace Shop\Controller;

use Framework\Controller\Controller;
use Framework\DI\Service;
use Framework\Exception\HttpNotFoundException;
use Framework\Model\ActiveRecord;
use Shop\Model\Cart;
use Shop\Model\DeliveryType;
use Shop\Model\Order;
use Shop\Model\OrderStatus;
use Shop\Model\PaymentType;

class OrderController extends Controller
{
    public function createAction()
    {
        $order = new Order();
        $cart = new Cart();

        if ($cart->getProductsCount() <= 0) {
            Service::get('session')->addFlush('warning', 'Unable to make order with empty cart.');
            return $this->redirect($this->generateRoute('home'));
        }

        $request = Service::get('request');

        if ($request->isPost()) {
            $products = $cart->getOrderedProducts();

            $order->setAddress($request->post('address'));
            $order->setDeliveryType(DeliveryType::findOne($request->post('deliveryType')));
            $order->setPaymentType(PaymentType::findOne($request->post('paymentType')));
            $order->setClient(Service::get('security')->getUser());
            $order->setDate(new \DateTime());

            foreach ($products as $product) {
                $order->addProducts($product, $cart->getProductCount($product));
            }
            $order->setTotalPrice($cart->getTotalPrice());

            if ($order->validate()) {
                $order->persist();
                ActiveRecord::flush();
                Service::get('session')->addFlush('success', 'Thank you. Order successfully sent.');
                $cart->clear();
                return $this->redirect($this->generateRoute('home'));
            }
        }

        $deliveryTypes = DeliveryType::getRepository()->findAll();
        $paymentTypes = PaymentType::getRepository()->findAll();

        return $this->render('form', [
            'order' => $order,
            'deliveryTypes' => $deliveryTypes,
            'paymentTypes' => $paymentTypes,
        ]);
    }

    public function updateAction($id)
    {
        $order = $this->findOne($id);
        $request = Service::get('request');

        if ($request->isPost()) {

            $order->setAddress($request->post('address'));
            $order->setDeliveryType(DeliveryType::findOne($request->post('deliveryType')));
            $order->setPaymentType(PaymentType::findOne($request->post('paymentType')));
            $order->setOrderStatus(OrderStatus::findOne($request->post('orderStatus')));

            if ($order->validate()) {
                ActiveRecord::flush();

                return $this->redirect($this->generateRoute('order_list'));
            }
        }

        $deliveryTypes = DeliveryType::getRepository()->findAll();
        $paymentTypes = PaymentType::getRepository()->findAll();
        $orderStatuses = OrderStatus::getRepository()->findAll();

        return $this->render('form', [
            'order' => $order,
            'deliveryTypes' => $deliveryTypes,
            'paymentTypes' => $paymentTypes,
            'orderStatuses' => $orderStatuses,
        ]);
    }

    public function showAction($id)
    {
        $order = $this->findOne($id);

        return $this->render('show', [
            'order' => $order,
        ]);
    }

    public function listAction()
    {
        $orders = Order::getRepository()->findBy([], ['date' => 'DESC']);

        return $this->render('list', [
            'orders' => $orders,
        ]);
    }

    /**
     * @param $id
     * @return Order
     * @throws HttpNotFoundException
     */
    private function findOne($id)
    {
        $order = Order::findOne($id);
        if (empty($order)) {
            throw new HttpNotFoundException();
        }

        return $order;
    }
}
