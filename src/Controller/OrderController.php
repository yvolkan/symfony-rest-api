<?php

namespace App\Controller;

use App\Dto\Response\Transformer\OrderResponseDtoTransformer;
use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class OrderController
 * @package App\Controller
 * @Route("/api", name="order_api")
 */
class OrderController extends ApiController
{
    /**
     * @var OrderResponseDtoTransformer $orderResponseDtoTransformer
     */
    private $orderResponseDtoTransformer;
    
    /**
     * @param OrderResponseDtoTransformer $orderResponseDtoTransformer
     */
    public function __construct(OrderResponseDtoTransformer $orderResponseDtoTransformer)
    {
        $this->orderResponseDtoTransformer = $orderResponseDtoTransformer;
    }
    
    /**
     * @param OrderRepository $orderRepository
     * @return JsonResponse
     * @Route("/orders", name="orders", methods={"GET"})
     */
    public function getOrders(UserInterface $user, OrderRepository $orderRepository): JsonResponse 
    {
        $data = $orderRepository->findBy([
            'user' => $user,
        ]);

        return $this->response(
            $this->orderResponseDtoTransformer->mapper($data)
        );
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ProductRepository $productRepository
     * @param ValidatorInterface $validator
     * @return JsonResponse
     * @throws Exception
     * @Route("/orders", name="orders_add", methods={"POST"})
     */
    public function createOrder(Request $request, UserInterface $user, EntityManagerInterface $entityManager, ProductRepository $productRepository, ValidatorInterface $validator): ?JsonResponse
    {
        try {
            if (! $product = $productRepository->find($request->get('productId'))) {
                return $this->respondNotFound("Product not found");
            }

            $order = new Order();
            $order->setUser($user);
            $order->setProduct($product);
            $order->setQuantity($request->get('quantity'));
            $order->setAddress($request->get('address'));
            $order->setShippingDate((new DateTime())->modify($product->getShippingDate() . ' days'));
            
            
            $violations = $validator->validate($order);
            if (count($violations) > 0) {
                $errors = [];
                foreach ($violations as $violation) {
                    $errors[$violation->getPropertyPath()] = $violation->getMessage();
                }
                
                return $this->respondValidationError($errors);
            }
            
            $entityManager->persist($order);
            $entityManager->flush();

            return $this->respondCreated([
                "success" => "Order added successfully"
            ]);
        } catch (Exception $e) {
            return $this->respondError("An error occured. " . $e->getMessage());
        }

    }

    /**
     * @param OrderRepository $orderRepository
     * @param $id
     * @return JsonResponse
     * @Route("/orders/{id}", name="orders_get", methods={"GET"})
     */
    public function getOrder(OrderRepository $orderRepository, UserInterface $user, $id): JsonResponse
    {
        $order = $orderRepository->findOneBy([
            'id' => $id,
            'user' => $user,
        ]);

        if (! $order) {
            return $this->respondNotFound("Order not found");
        }
        
        return $this->response(
            $this->orderResponseDtoTransformer->transformFromObject($order)
        );
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param OrderRepository $orderRepository
     * @param $id
     * @return JsonResponse
     * @Route("/orders/{id}", name="orders_put", methods={"PUT"})
     */
    public function updateOrder(Request $request, UserInterface $user, EntityManagerInterface $entityManager, OrderRepository $orderRepository, $id): ?JsonResponse
    {
        try {
            $order = $orderRepository->findOneBy([
                'id' => $id,
                'user' => $user,
            ]);

            if (! $order) {
                return $this->respondNotFound("Order not found");
            }
            
            $dateNow = new DateTime();
            if ($dateNow > $order->getShippingDate()) {
                return $this->respondValidationError("Shipping date has passed");
            }

            if ($request->get('quantity')) {
                $order->setQuantity($request->get('quantity'));
            }
            
            if ($request->get('address')) {
                $order->setAddress($request->get('address'));
            }

            $entityManager->flush();

            return $this->respondCreated([
                "success" => "Order updated successfully"
            ]);
        } catch (Exception $e) {
            return $this->respondError("An error occured. " . $e->getMessage());
        }

    }

    /**
     * @param OrderRepository $orderRepository
     * @param $id
     * @return JsonResponse
     * @Route("/orders/{id}", name="orders_delete", methods={"DELETE"})
     */
    public function deleteOrder(UserInterface $user, EntityManagerInterface $entityManager, OrderRepository $orderRepository, $id): JsonResponse
    {
        $order = $orderRepository->findOneBy([
            'id' => $id,
            'user' => $user,
        ]);

        if (! $order) {
            return $this->respondNotFound("Order not found");
        }

        $entityManager->remove($order);
        $entityManager->flush();
        
        return $this->respondWithSuccess("Order deleted successfully");
    }
}