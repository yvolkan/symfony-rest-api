<?php
namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="products")
 * @ORM\Entity
 */
class Product
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $name;
    
    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $shipping_days;
    
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * @param string $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }
    
    /**
     * @return mixed
     */
    public function getShippingDate():? int
    {
        return $this->shipping_days;
    }

    /**
     * @param int|nullable $shipping_days
     * @return void
     */
    public function setShippingDate(?int $shipping_days): void
    {
        $this->shipping_days = $shipping_days;
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
     * @return void
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
        $this->create_date = new DateTime('now');
    }
}
