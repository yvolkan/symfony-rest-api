<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends AbstractController
{

    /**
     * @var integer HTTP status code - 200 (OK) by default
     */
    protected $statusCode = Response::HTTP_OK;

    /**
     * Gets the value of statusCode.
     *
     * @return integer
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Sets the value of statusCode.
     *
     * @param integer $statusCode the status code
     *
     * @return self
     */
    protected function setStatusCode($statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Returns a JSON response
     *
     * @param array $data
     * @param array $headers
     *
     * @return JsonResponse
     */
    public function response($data, $headers = []): JsonResponse
    {
        return new JsonResponse($data, $this->getStatusCode() , $headers);
    }

    /**
     * Sets an error message and returns a JSON response
     *
     * @param string|array $errors
     * @param $headers
     * @return JsonResponse
     */
    public function respondWithErrors($errors, $headers = []): JsonResponse
    {
        $data = ['errors' => $errors, ];

        return new JsonResponse($data, $this->getStatusCode() , $headers);
    }

    /**
     * Sets an error message and returns a JSON response
     *
     * @param string|array $success
     * @param $headers
     * @return JsonResponse
     */
    public function respondWithSuccess($success, $headers = []): JsonResponse
    {
        $data = ['success' => $success, ];

        return new JsonResponse($data, $this->getStatusCode() , $headers);
    }

    /**
     * Returns a 401 Unauthorized http response
     *
     * @param string|array $message
     *
     * @return JsonResponse
     */
    public function respondUnauthorized($message = 'Not authorized!'): JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_UNAUTHORIZED)
            ->respondWithErrors($message);
    }

    /**
     * Returns a 422 Unprocessable Entity
     *
     * @param string|array $message
     *
     * @return JsonResponse
     */
    public function respondValidationError($message = 'Validation errors'): JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->respondWithErrors($message);
    }

    /**
     * Returns a 404 Not Found
     *
     * @param string|array $message
     *
     * @return JsonResponse
     */
    public function respondNotFound($message = 'Not found!'): JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)
            ->respondWithErrors($message);
    }
    
    /**
     * Returns a 500 Not Found
     *
     * @param string|array $message
     *
     * @return JsonResponse
     */
    public function respondError($message = 'An error occured'): JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)
            ->respondWithErrors($message);
    }

    /**
     * Returns a 201 Created
     *
     * @param string|array $data
     *
     * @return JsonResponse
     */
    public function respondCreated($data = []): JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_CREATED)
            ->response($data);
    }

}
