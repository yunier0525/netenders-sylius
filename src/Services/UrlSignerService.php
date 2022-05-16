<?php

namespace App\Services;

use Symfony\Component\HttpKernel\UriSigner;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UrlSignerService
{
    public function __construct(
        private UrlGeneratorInterface $router,
        private UriSigner $uriSigner
    ) {
    }

    public function generateUrlSigned(
        string $routeName,
        string $userId,
        string $userEmail,
        array $extraParams = []
    ) {
        $generatedAt = time();
        $expiryTimestamp = $generatedAt + 9999;

        $extraParams['token'] = $this->createToken($userId, $userEmail);
        $extraParams['expires'] = $expiryTimestamp;

        $uri = $this->router->generate($routeName, $extraParams, UrlGeneratorInterface::ABSOLUTE_URL);

        $signature = $this->uriSigner->sign($uri);

        return $signature;
    }

    private function createToken(
        string $userId,
        string $email
    ): string {
        $encodedData = json_encode([$userId, $email]);

        return base64_encode(
            hash_hmac(
                'sha256',
                $encodedData,
                getenv('APP_SECRET'),
                true
            )
        );
    }
}
