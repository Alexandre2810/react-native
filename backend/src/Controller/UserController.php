<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\JWTAuthenticator;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class UserController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/login', name: 'app_login')]
    public function login(CookieHelper $cookieHelper, JWTHelper $JWTHelper): JsonResponse
    {
        /** @var $user ?User */
        $user = $this->getUser();

        return $this->json(
            [
                'message' => 'Connexion réussie, bonjour ' . $user->getUsername() . '!',
                'jwt' => $JWTHelper->createJWT($user),
                'status'=> 200
            ],
            200,
            ['set-cookie' => $cookieHelper->buildCookie($user)]
        );
    }

    /**
     * @throws Exception
     */
    #[Route('/register', name: 'app_register', methods: 'POST')]
    public function register(Request $request,EntityManagerInterface $entityManager,UserPasswordHasherInterface $hasher,UserAuthenticatorInterface $authenticator,JWTAuthenticator $JWTAuthenticator,): JsonResponse
    {
        if (!empty($request->request->get('password'))) {
            $user = new User();
            $user->setUsername($request->request->get('username'))
                ->setPassword($hasher->hashPassword($user, $request->request->get('password')));

            $entityManager->persist($user);
            $entityManager->flush();

            $authenticator->authenticateUser(
                $user,
                $JWTAuthenticator,
                $request
            );

            return $this->json(
                [
                    'message' => 'Inscription réussie, bonjour ' . $user->getUsername() . '!',
                    'status'=> 200
                ],
                200,
            );
        }
    }
}
