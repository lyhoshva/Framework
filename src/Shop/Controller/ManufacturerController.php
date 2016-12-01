<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 27.11.16
 * Time: 22:29
 */

namespace Shop\Controller;

use Framework\Controller\Controller;
use Framework\DI\Service;
use Framework\Exception\HttpNotFoundException;
use Framework\Model\ActiveRecord;
use Shop\Model\Manufacturer;

class ManufacturerController extends Controller
{
    public function listAction()
    {
        $manufacturers = Manufacturer::getRepository()->findAll();
        return $this->render('list', [
            'manufacturers' => $manufacturers,
        ]);
    }

    public function createAction()
    {
        $manufacturer = new Manufacturer();
        $request = Service::get('request');

        if (Service::get('request')->isPost()) {

            $manufacturer->setName($request->post('name'));
            if ($manufacturer->validate()) {
                $manufacturer->persist();
                ActiveRecord::flush();
                return $this->redirect($this->generateRoute('manufacturers_list'));
            }
        }

        return $this->render('form', [
            'manufacturer' => $manufacturer,
        ]);
    }

    public function updateAction($id)
    {
        $manufacturer = $this->findOne($id);
        $request = Service::get('request');

        if (Service::get('request')->isPost()) {

            $manufacturer->setName($request->post('name'));
            if ($manufacturer->validate()) {
                ActiveRecord::flush();
                return $this->redirect($this->generateRoute('manufacturers_list'));
            }
        }

        return $this->render('form', [
            'manufacturer' => $manufacturer,
        ]);
    }

    public function deleteAction($id)
    {
        $manufacturer = $this->findOne($id);
        $manufacturer->delete();
        ActiveRecord::flush();

        return $this->redirect($this->generateRoute('manufacturers_list'));
    }

    /**
     * @param $id
     * @return Manufacturer
     * @throws HttpNotFoundException
     */
    private function findOne($id)
    {
        $manufacturer = Manufacturer::findOne($id);
        if (empty($manufacturer)) {
            throw new HttpNotFoundException();
        }

        return $manufacturer;
    }
}
