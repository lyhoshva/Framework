<?php
/**
 * Created by PhpStorm.
 * User: dgilan
 * Date: 10/17/14
 * Time: 12:41 PM
 */

namespace Shop\Controller;

use Shop\Model\User;
use Framework\Controller\Controller;
use Framework\DI\Service;
use Framework\Exception\DatabaseException;

class SecurityController extends Controller
{

    public function loginAction()
    {
        if (Service::get('security')->isAuthenticated()) {
            return $this->redirect($this->generateRoute('home'));
        }
        $errors = array();

        if ($this->getRequest()->isPost()) {

            if ($user = User::getRepository()->findOneBy(['email' => $this->getRequest()->post('email')])) {
                if ($user->verifyPassword($this->getRequest()->post('password'))) {
                    Service::get('security')->setUser($user);
                    $returnUrl = Service::get('session')->returnUrl;
                    unset(Service::get('session')->returnUrl);
                    return $this->redirect(!is_null($returnUrl)?$returnUrl:$this->generateRoute('home'));
                }
            }

            array_push($errors, 'Invalid username or password');
        }

        return $this->render('login.html', array('errors' => $errors));
    }

    public function logoutAction()
    {
        Service::get('security')->clear();
        return $this->redirect($this->generateRoute('home'));
    }

    public function signinAction()
    {
        if (Service::get('security')->isAuthenticated()) {
            return $this->redirect($this->generateRoute('home'));
        }
        $errors = array();

        if ($this->getRequest()->isPost()) {
            try{
                $user           = new User();
                $user->setName('asdasdadsa');
                $user->setPhone('7777');
                $user->setEmail($this->getRequest()->post('email'));
                $user->setPassword($this->getRequest()->post('password'));
                $user->setRole('ROLE_USER');
                $user->persist();
                $user->flush();
                return $this->redirect($this->generateRoute('home'));
            } catch(DatabaseException $e){
                $errors = array($e->getMessage());
            }
        }

        return $this->render('signin.html', array('errors' => $errors));
    }
}