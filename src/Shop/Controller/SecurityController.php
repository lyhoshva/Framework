<?php
/**
 * Created by PhpStorm.
 * User: dgilan
 * Date: 10/17/14
 * Time: 12:41 PM
 */

namespace Shop\Controller;

use Framework\Controller\Controller;
use Framework\DI\Service;
use Shop\Model\Roles;
use Shop\Model\User;

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

    public function signupAction()
    {
        if (Service::get('security')->isAuthenticated()) {
            return $this->redirect($this->generateRoute('home'));
        }

        $user = new User();
        if ($this->getRequest()->isPost()) {
            $user->setName($this->getRequest()->post('name'));
            $user->setPhone($this->getRequest()->post('phone'));
            $user->setEmail($this->getRequest()->post('email'));
            $user->setPassword($this->getRequest()->post('password'));
            $user->setRePassword($this->getRequest()->post('rePassword'));
            $user->setRole(Roles::ROLE_USER);
            if ($user->validate()) {
                $user->persist();
                $user->flush();
                Service::get('security')->setUser($user);
                return $this->redirect($this->generateRoute('home'));
            }
        }

        return $this->render('signup.html', [
            'user' => $user,
        ]);
    }
}