<?php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthController extends ApiController
{
    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordHasherInterface $userPasswordHasherInterface
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher, ValidatorInterface $validator): JsonResponse
    {
        try {
            $username = $request->get('username');
            $password = $request->get('password');
            $email = $request->get('email');
            
            $input = [
                'username' => $username,
                'password' => $password,
                'email' => $email,
            ];
        
            $constraints = new Assert\Collection([
                'username' => [
                    new Assert\NotBlank()
                ],
                'password' => [
                    new Assert\NotBlank()
                ],
                'email' => [
                    new Assert\NotBlank(),
                    new Assert\Email()
                ],
            ]);
        
            $violations = $validator->validate($input, $constraints);
            
            if (count($violations) > 0) {
                $errors = [];
                foreach ($violations as $violation) {
                    $errors[$violation->getPropertyPath()] = $violation->getMessage();
                }
                
                return $this->respondValidationError($errors);
            }

            $user = new User();
            $user->setUsername($username);
            $user->setPassword($userPasswordHasher->hashPassword($user, $password));
            $user->setEmail($email);
            
            $entityManager->persist($user);
            $entityManager->flush();
            
            return $this->respondWithSuccess(sprintf('User %s successfully created', $user->getUsername()));
        } catch (Exception $e) {
            return $this->respondError("An error occured. " . $e->getMessage());
        }
    }

    /**
     * @param UserInterface $user
     * @param JWTTokenManagerInterface $JWTManager
     * @return JsonResponse
     */
    public function login(UserInterface $user, JWTTokenManagerInterface $JWTManager): JsonResponse
    {
        return new JsonResponse(['token' => $JWTManager->create($user) ]);
    }
}

