<?php

namespace App\Dto\Response;

use JMS\Serializer\Annotation as Serialization;

class ProductResponseDto
{
    /**
     * @Serialization\Type("id")
     */
    public $id;

    /**
     * @Serialization\Type("string")
     */
    public $name;
}