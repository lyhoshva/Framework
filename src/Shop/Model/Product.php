<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 23.11.16
 * Time: 22:55
 */

namespace Shop\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Framework\Model\ActiveRecord;
use Framework\Validation\Filter\Integer;
use Framework\Validation\Filter\Length;
use Framework\Validation\Filter\NotBlank;
use Framework\Validation\Filter\Number;

/** @Entity @Table(name="products") */
class Product extends ActiveRecord
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    private $id;
    /** @Column(type="string") **/
    private $title;
    /** @Column(type="integer") **/
    private $price;
    /**
     * @ManyToOne(targetEntity="\Shop\Model\Manufacturer")
     * @JoinColumn(name="manufacturer_id", referencedColumnName="id")
     */
    private $manufacturer;
    /** @Column(type="decimal", precision=2, scale=1) **/
    private $display;
    /** @Column(type="decimal", precision=3, scale=1) **/
    private $camera;
    /** @Column(type="integer") **/
    private $memory;
    /** @Column(type="string") **/
    private $processor;
    /** @Column(type="integer") **/
    private $sim_count;
    /** @OneToMany(targetEntity="\Shop\Model\OrderedProducts", mappedBy="product", cascade={"persist"}) */
    private $orderedProduct;

    public function __construct()
    {
        $this->orderedProduct = new ArrayCollection();
    }

    /**
     * @inheritdoc
     */
    public function getRules()
    {
        return array(
            'title'   => [
                new NotBlank(),
                new Length(2, 100)
            ],
            'processor'   => [
                new NotBlank(),
                new Length(2, 100)
            ],
            'price'   => [
                new NotBlank(),
                new Integer(),
            ],
            'memory'   => [
                new NotBlank(),
                new Integer(),
            ],
            'simCount'   => [
                new NotBlank(),
                new Integer(),
            ],
            'display'   => [
                new NotBlank(),
                new Number(),
            ],
            'camera'   => [
                new NotBlank(),
                new Number(),
            ],
            'manufacturer'   => [
                new NotBlank(),
            ],
        );
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * @param mixed $display
     */
    public function setDisplay($display)
    {
        $this->display = $display;
    }

    /**
     * @return mixed
     */
    public function getCamera()
    {
        return $this->camera;
    }

    /**
     * @param mixed $camera
     */
    public function setCamera($camera)
    {
        $this->camera = $camera;
    }

    /**
     * @return mixed
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * @param mixed $memory
     */
    public function setMemory($memory)
    {
        $this->memory = $memory;
    }

    /**
     * @return mixed
     */
    public function getProcessor()
    {
        return $this->processor;
    }

    /**
     * @param mixed $processor
     */
    public function setProcessor($processor)
    {
        $this->processor = $processor;
    }

    /**
     * @return mixed
     */
    public function getSimCount()
    {
        return $this->sim_count;
    }

    /**
     * @param mixed $sim_count
     */
    public function setSimCount($sim_count)
    {
        $this->sim_count = $sim_count;
    }

    /**
     * @return Manufacturer
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * @param Manufacturer $manufacturer
     */
    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;
    }

    /**
     * @return mixed
     */
    public function getOrderedProduct()
    {
        return $this->orderedProduct;
    }
}
