<?php
namespace App\Dto\Response\Transformer;

use App\Dto\Exception\UnexpectedTypeException;
use App\Dto\Response\OrderResponseDto;
use App\Entity\Order;

class OrderResponseDtoTransformer extends AbstractResponseDtoTransformer
{
    private $userResponseDtoTransformer;
    private $productResponseDtoTransformer;

    /**
     * @param UserResponseDtoTransformer $userResponseDtoTransformer
     * @param ProductResponseDtoTransformer $productResponseDtoTransformer
     */
    public function __construct(
        UserResponseDtoTransformer $userResponseDtoTransformer,
        ProductResponseDtoTransformer $productResponseDtoTransformer
    ) {
        $this->userResponseDtoTransformer = $userResponseDtoTransformer;
        $this->productResponseDtoTransformer = $productResponseDtoTransformer;
    }
    
    /**
     * @param $orders
     *
     * @return iterable
     */
    public function mapper($orders): iterable
    {
        return $this->transformFromObjects($orders);
    }

    /**
     * @param Order $order
     *
     * @return null|OrderResponseDto
     */
    public function transformFromObject($order): ?OrderResponseDto
    {   
        if (! $order instanceof Order) {
            return null;
        }
        
        $dto = new OrderResponseDto();
        $dto->id = $order->getId();
        $dto->user = $this->userResponseDtoTransformer->transformFromObject($order->getUser());
        $dto->product = $this->productResponseDtoTransformer->transformFromObject($order->getProduct());
        
        $dto->order_code = $order->getOrderCode();
        $dto->address = $order->getAddress();
        $dto->quantity = $order->getQuantity();
        $dto->shipping_date = $order->getShippingDate();
        $dto->created_at = $order->getCreateDate();
        
        return $dto;
    }
}