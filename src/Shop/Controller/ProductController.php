<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 26.11.16
 * Time: 18:41
 */

namespace Shop\Controller;

use Framework\Controller\Controller;
use Framework\DI\Service;
use Framework\Exception\HttpForbiddenException;
use Framework\Exception\HttpNotFoundException;
use Framework\Model\ActiveRecord;
use Framework\Security\Roles;
use Shop\Model\Manufacturer;
use Shop\Model\Product;

class ProductController extends Controller
{
    public function listAction()
    {
        $products = Product::getRepository()->findAll();

        return $this->render('list', [
            'products' => $products,
        ]);
    }

    public function showAction($id)
    {
        $product = $this->findOne($id);

        return $this->render('show', [
            'product' => $product,
        ]);
    }

    public function createAction()
    {
        if (!Service::get('security')->checkPermission([Roles::ROLE_ADMIN])) {
            throw new HttpForbiddenException();
        }

        $product = new Product();
        $request = Service::get('request');

        if ($request->isPost()) {
            $manufacturer = Manufacturer::findOne($request->post('manufacturer'));
            $product->setDisplay($request->post('display'));
            $product->setTitle($request->post('title'));
            $product->setManufacturer($manufacturer);
            $product->setProcessor($request->post('processor'));
            $product->setCamera($request->post('camera'));
            $product->setMemory($request->post('memory'));
            $product->setPrice($request->post('price'));
            $product->setSimCount($request->post('simCount'));
            if ($product->validate()) {
                $product->persist();
                ActiveRecord::flush();
                return $this->redirect($this->generateRoute('product', ['id' => $product->getId()]));
            }
        }

        $manufacturers = Manufacturer::getRepository()->findAll();

        return $this->render('form', [
            'product' => $product,
            'manufacturers' => $manufacturers,
        ]);
    }

    public function updateAction($id)
    {
        if (!Service::get('security')->checkPermission([Roles::ROLE_ADMIN])) {
            throw new HttpForbiddenException();
        }

        $product = $this->findOne($id);
        $request = Service::get('request');

        if (Service::get('request')->isPost()) {

            $manufacturer = Manufacturer::findOne($request->post('manufacturer'));
            $product->setDisplay($request->post('display'));
            $product->setTitle($request->post('title'));
            $product->setManufacturer($manufacturer);
            $product->setProcessor($request->post('processor'));
            $product->setCamera($request->post('camera'));
            $product->setMemory($request->post('memory'));
            $product->setPrice($request->post('price'));
            $product->setSimCount($request->post('simCount'));
            if ($product->validate()) {
                ActiveRecord::flush();
                return $this->redirect($this->generateRoute('product', ['id' => $product->getId()]));
            }
        }

        $manufacturers = Manufacturer::getRepository()->findAll();

        return $this->render('form', [
            'product' => $product,
            'manufacturers' => $manufacturers,
        ]);
    }

    public function deleteAction($id)
    {
        if (!Service::get('security')->checkPermission([Roles::ROLE_ADMIN])) {
            throw new HttpForbiddenException();
        }

        $product = $this->findOne($id);

        $product->delete();
        ActiveRecord::flush();

        return $this->redirect($this->generateRoute('home'));
    }

    /**
     * @param $id
     * @return Product
     * @throws HttpNotFoundException
     */
    private function findOne($id)
    {
        $product = Product::findOne($id);
        if (empty($product)) {
            throw new HttpNotFoundException();
        }

        return $product;
    }
}
