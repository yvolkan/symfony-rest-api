<?php
namespace App\Dto\Response\Transformer;

use App\Dto\Response\ProductResponseDto;
use App\Entity\Product;

class ProductResponseDtoTransformer extends AbstractResponseDtoTransformer
{
    /**
     * @param Product $product
     *
     * @return ProductResponseDto
     */
    public function transformFromObject($product): ProductResponseDto
    {
        $dto = new ProductResponseDto();
        
        if ($product instanceof Product) {
            $dto->id = $product->getId();
            $dto->name = $product->getName();
        }

        return $dto;
    }
}