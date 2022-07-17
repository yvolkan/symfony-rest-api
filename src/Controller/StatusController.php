<?php
namespace App\Controller;

use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StatusController
 * @package App\Controller
 * @Route("/api", name="status_api")
 */
class StatusController extends ApiController
{
    /**
     * Api status
     * 
     * @return JsonResponse
     * @Route("/status", name="index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        return $this->response([
            'status' => 'ok',
            'date' => (new DateTime())->format(DateTime::ATOM),
        ]);
    }
}