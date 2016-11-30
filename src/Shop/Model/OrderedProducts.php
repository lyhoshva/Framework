<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 24.11.16
 * Time: 21:15
 */

namespace Shop\Model;

use Framework\Model\ActiveRecord;

/** @Entity @Table(name="ordered_products") */
class OrderedProducts extends ActiveRecord
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    private $id;
    /** @ManyToOne(targetEntity="\Shop\Model\Order", inversedBy="orderedProducts") */
    private $order;
    /** @ManyToOne(targetEntity="\Shop\Model\Product", inversedBy="orderedProducts") */
    private $product;
    /** @Column(type="integer") **/
    private $count;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param integer $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }
}
