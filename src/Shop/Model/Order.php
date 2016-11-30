<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 24.11.16
 * Time: 0:17
 */

namespace Shop\Model;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Framework\Model\ActiveRecord;
use Framework\Validation\Filter\Integer;
use Framework\Validation\Filter\Length;
use Framework\Validation\Filter\NotBlank;

/** @Entity @Table(name="orders") */
class Order extends ActiveRecord
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /**
     * @ManyToOne(targetEntity="\Shop\Model\User")
     * @JoinColumn(name="client_id", referencedColumnName="id")
     */
    protected $client;
    /**
     * @ManyToOne(targetEntity="\Shop\Model\DeliveryType")
     * @JoinColumn(name="delivery_type_id", referencedColumnName="id")
     */
    protected $delivery_type;
    /**
     * @ManyToOne(targetEntity="\Shop\Model\PaymentType")
     * @JoinColumn(name="payment_type_id", referencedColumnName="id")
     */
    protected $payment_type;
    /**
     * @ManyToOne(targetEntity="\Shop\Model\OrderStatus")
     * @JoinColumn(name="order_status_id", referencedColumnName="id")
     */
    protected $order_status;
    /** @Column(type="string") */
    protected $address;
    /** @Column(type="integer", name="total_price") */
    protected $totalPrice;
    /** @Column(type="datetime") */
    protected $date;
    /** @OneToMany(targetEntity="\Shop\Model\OrderedProducts", mappedBy="order", cascade={"persist"}) */
    protected $orderedProducts;

    public function __construct()
    {
        $this->orderedProducts = new ArrayCollection();
    }

    /**
     * @inheritdoc
     */
    public function getRules()
    {
        return array(
            'address' => [
                new NotBlank(),
                new Length(2, 255)
            ],
            'date' => [
                new NotBlank(),
            ],
            'client' => [
                new NotBlank(),
            ],
            'deliveryType' => [
                new NotBlank(),
            ],
            'paymentType' => [
                new NotBlank(),
            ],
            'totalPrice' => [
                new NotBlank(),
                new Integer(),
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
     * @return User
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param User $client
     */
    public function setClient(User $client)
    {
        $this->client = $client;
    }

    /**
     * @return DeliveryType
     */
    public function getDeliveryType()
    {
        return $this->delivery_type;
    }

    /**
     * @param DeliveryType $delivery_type
     */
    public function setDeliveryType(DeliveryType $delivery_type)
    {
        $this->delivery_type = $delivery_type;
    }

    /**
     * @return PaymentType
     */
    public function getPaymentType()
    {
        return $this->payment_type;
    }

    /**
     * @param PaymentType $payment_type
     */
    public function setPaymentType(PaymentType $payment_type)
    {
        $this->payment_type = $payment_type;
    }

    /**
     * @return OrderStatus
     */
    public function getOrderStatus()
    {
        return $this->order_status;
    }

    /**
     * @param OrderStatus $order_status
     */
    public function setOrderStatus(OrderStatus $order_status)
    {
        $this->order_status = $order_status;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * @param mixed $totalPrice
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }

    /**
     * @return mixed
     */
    public function getOrderedProducts()
    {
        return $this->orderedProducts;
    }

    /**
     * @param Product $product
     * @param int $count
     */
    public function addProducts(Product $product, $count)
    {
        $orderedProduct = new OrderedProducts();
        $orderedProduct->setOrder($this);
        $orderedProduct->setProduct($product);
        $orderedProduct->setCount($count);
        $this->orderedProducts[] = $orderedProduct;
    }

}
