<?php

namespace App\Service;

use DateTimeImmutable;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Symfony\Component\HttpFoundation\Cookie;


class CookieGenerator
{
    private $secret;
    private $jwt;

    /**
     * @param string $secret
     * @param JWTprovider $JWTprovider
     */
    public function __construct(string $secret, JWTprovider $JWTprovider)
    {
        // JWT secret key (services.yaml)
        $this->secret = $secret;
        $this->jwt = $JWTprovider->getJwt();
    }

    public function generate(): Cookie
    {
        return Cookie::create(
            'mercureAuthorization',
            $this->jwt,
            0,
            '/.well-known/mercure',
            null,  // null = domaine automatique
            false, // secure = false en HTTP
            false, // httpOnly = false obligatoire
            false,
            'lax'
        );
    }
}
