<?php

namespace App\Dto\Response;

use JMS\Serializer\Annotation as Serialization;

class OrderResponseDto
{
    /**
     * @Serialization\Type("int")
     */
    public $id;
    
    /**
     * @Serialization\Type("App\Dto\Response\UserResponseDto")
     */
    public $user;
    
    /**
     * @Serialization\Type("App\Dto\Response\ProductResponseDto")
     */
    public $product;

    /**
     * @Serialization\Type("string")
     */
    public $order_code;
    
    /**
     * @Serialization\Type("int")
     */
    public $quantity;
    
    /**
     * @Serialization\Type("string")
     */
    public $address;
    
    /**
     * @Serialization\Type("DateTime")
     */
    public $shipping_date;
    
    /**
     * @Serialization\Type("DateTime")
     */
    public $created_at;
    
}