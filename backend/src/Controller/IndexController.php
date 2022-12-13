<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    #[isGranted('ROLE_USER')]
    public function index(UserRepository $userRepository): JsonResponse
    {
        /** @var $user ?User */
        $user = $this->getUser();

        return $this->json([
            'users' => $userRepository->findAllButMe($user)
        ], 200, []);
    }

    #[Route('/mercure-publish', name: 'app_mercure_publish')]
    public function publish(HubInterface $hub): JsonResponse
    {
        $update = new Update(
            ["https://example.com/my-private-topic"],
            json_encode(["message"=>"Hello Monde from Symfony !"])
        );

        $hub->publish($update);

        return $this->json(["message" => "Data published"]);
    }
}
