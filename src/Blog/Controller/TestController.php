<?php
/**
 * Created by PhpStorm.
 * User: dgilan
 * Date: 10/15/14
 * Time: 3:19 PM
 */

namespace Blog\Controller;

use Framework\Controller\Controller;
use Framework\DI\Service;
use Framework\Response\Response;

class TestController extends Controller
{
    public function redirectAction()
    {
        return $this->redirect('/');
    }

    public function getJsonAction()
    {
        Service::get('app')->response_format = Response::FORMAT_JSON;
        return array('body' => 'Hello World');
    }
} 