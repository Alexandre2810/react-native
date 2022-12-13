<?php

namespace App\Service;

use App\Entity\User;
use Firebase\JWT\JWT;
use Symfony\Component\HttpFoundation\Cookie;

class CookieHelper
{

    private string $mercureSecret;
    private JWTHelper $JWTHelper;

    public function __construct(string $mercureSecret, JWTHelper $JWTHelper)
    {
        $this->mercureSecret = $mercureSecret;
        $this->JWTHelper = $JWTHelper;
    }

    public function buildCookie(User $user,): string
    {
        return Cookie::create(
            "jwtpingui",
            $this->JWTHelper->createJWT($user),
            new \DateTime("10 minutes"),
            '',
            'localhost',
            true,
            true,
            true,
            Cookie::SAMESITE_STRICT
        );
    }

    public function createMercureCookie(User $user): string
    {
        $jwt = $this->JWTHelper->createJWT($user);

        return Cookie::create(
            'mercureAuthorization',
            $jwt,
            new \DateTime("10 minutes"),
            '/.well-known/mercure',
            'localhost',
            true,
            true,
            false,
            Cookie::SAMESITE_STRICT
        );
    }
}