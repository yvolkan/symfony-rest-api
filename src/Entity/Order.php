<?php
namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 * @ORM\HasLifecycleCallbacks()
 */
class Order
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @ORM\Column(type="string", length=20)
     *
     */
    private $order_code;
    
    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(
     * message = "Quantity value should not be blank"
     * )
     * @Assert\GreaterThan(
     * value = "0"
     * )
     */
    private $quantity;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(
     * message = "Address value should not be blank"
     * )
     */
    private $address;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $shipping_date;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $create_date;

    /**
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }
    
    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
    
    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
    
    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }
    
    /**
     * @param Product $product
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }
    
    /**
     * @return string
     */
    public function getOrderCode(): string
    {
        return $this->order_code;
    }
    
    /**
     * @param string $order_code
     */
    public function setOrderCode($order_code): void
    {
        $this->order_code = $order_code;
    }
    
    /**
     * @return integer
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
    
    /**
     * @param integer $quantity
     */
    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }
    
    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }
    
    /**
     * @param string $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getShippingDate():? DateTime
    {
        return $this->shipping_date;
    }

    /**
     * @param DateTime $shipping_date
     * @return Post
     */
    public function setShippingDate(DateTime $shipping_date): void
    {
        $this->shipping_date = $shipping_date;
    }
    
    /**
     * @return mixed
     */
    public function getCreateDate():? DateTime
    {
        return $this->create_date;
    }

    /**
     * @param DateTime $create_date
     * @return Post
     */
    public function setCreateDate(DateTime $create_date): void
    {
        $this->create_date = $create_date;
    }

    /**
     * @throws \Exception
     * @ORM\PrePersist()
     */
    public function beforeSave()
    {
        $this->setOrderCode('PATH_'. uniqid());
        $this->setCreateDate(new DateTime('now'));
    }
}
