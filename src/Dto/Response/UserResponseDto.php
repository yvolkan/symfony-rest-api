<?php

namespace App\Dto\Response;

use JMS\Serializer\Annotation as Serialization;

class UserResponseDto
{
    /**
     * @Serialization\Type("id")
     */
    public $id;

    /**
     * @Serialization\Type("string")
     */
    public $username;
    
    /**
     * @Serialization\Type("string")
     */
    public $email;
}