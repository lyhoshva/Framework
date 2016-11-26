<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 23.11.16
 * Time: 22:34
 */

namespace Shop\Model;

use Framework\Model\ActiveRecord;
use Framework\Validation\Filter\Length;
use Framework\Validation\Filter\NotBlank;

/** @Entity @Table(name="delivery_type") */
class DeliveryType extends ActiveRecord
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    private $id;
    /** @Column(type="string") **/
    private $name;

    /**
     * @inheritdoc
     */
    public function getRules()
    {
        return array(
            'name'   => array(
                new NotBlank(),
                new Length(2, 50)
            ),
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
}
