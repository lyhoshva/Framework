<?php
/**
 * Created by PhpStorm.
 * User: dgilan
 * Date: 10/17/14
 * Time: 12:09 PM
 */

namespace Shop\Model;

use Framework\Model\ActiveRecord;
use Framework\Security\Model\UserInterface;
use Framework\Validation\Filter\Length;
use Framework\Validation\Filter\Match;
use Framework\Validation\Filter\NotBlank;
use Framework\Validation\Filter\StringValidator;

/**
 * @Entity @Table(name="users")
 * @HasLifecycleCallbacks
 */
class User extends ActiveRecord implements UserInterface
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    private $id;
    /** @Column(type="string") **/
    private $email;
    /** @Column(type="string") **/
    private $name;
    /** @Column(type="string") **/
    private $phone;
    /** @Column(type="string") **/
    private $password_hash;
    private $re_password_hash;
    /** @Column(type="string") **/
    private $role;
    /**
     * @OneToMany(targetEntity="\Shop\Model\Order", mappedBy="client")
     * @JoinColumn(name="client_id", referencedColumnName="id")
     */
    private $orders;

    /**
     * @inheritdoc
     */
    public function getRules()
    {
        return array(
            'name'   => [
                new NotBlank(),
                new Length(2, 100),
                new StringValidator(),
            ],
            'email'   => [
                new NotBlank(),
                new Length(5, 100),
                new StringValidator(),
            ],
            'phone'   => [
                new NotBlank(),
                new Length(5, 20),
                new StringValidator(),
            ],
            'password'   => [
                new NotBlank(),
                new StringValidator(),
            ],
            'rePassword'   => [
                new NotBlank(),
                new StringValidator(),
                new class ($this->getPassword()){
                    protected $password;

                    public function __construct($password)
                    {
                        $this->password = $password;
                    }

                    public function validate($var)
                    {
                        return $var == $this->password ? true : 'Password and password confirm are not identical';
                    }
                },
            ],
            'role'   => [
                new NotBlank(),
                new StringValidator(),
            ],
        );
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password_hash;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = $password;
    }

    /**
     * @return string
     */
    public function getRePassword()
    {
        return $this->re_password_hash;
    }

    /**
     * @param string $re_password
     */
    public function setRePassword($re_password)
    {
        $this->re_password_hash = $re_password;
    }

    /**
     * Verify password
     *
     * @param $password string
     * @return bool
     */
    public function verifyPassword($password)
    {
        if ($this->getPassword() === md5($password)) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @PrePersist
     */
    public function encryptPassword()
    {
        $this->password_hash = md5($this->password_hash);
    }
}
