<?php

declare(strict_types=1);

namespace App\Security;

use App\Negotiation\ContentNegotiator;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Serializer\SerializerInterface;

final class JwtTokenAuthenticator extends AbstractGuardAuthenticator
{
    public function __construct(
        private JWTEncoderInterface $jwtEncoder,
        private SerializerInterface $serializer,
        private ContentNegotiator $contentNegotiator,
    ) {
    }

    public function supports(Request $request)
    {
        if (!$request->headers->has('Authorization')) {
            return false;
        }

        return true;
    }

    public function getCredentials(Request $request)
    {
        $extractor = new AuthorizationHeaderTokenExtractor(
            'Bearer',
            'Authorization'
        );

        return $extractor->extract($request);
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        try {
            $data = $this->jwtEncoder->decode($credentials);
        } catch (JWTDecodeFailureException $decodeFailureException) {
            throw new CustomUserMessageAuthenticationException('Invalid token.', [], 0, $decodeFailureException);
        }

        $username = $data['username'];

        return $userProvider->loadUserByUsername($username);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $error = [
            'error' => [
                'message' => 'Invalid credentials.',
                'detail' => 'Valid token required.',
            ],
        ];

        $serializedError = $this->serializer->serialize($error, $request->getRequestFormat());

        return new Response($serializedError, Response::HTTP_UNAUTHORIZED, [
            'Content-Type' => $this->contentNegotiator->getNegotiatedContentType(),
        ]);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // do nothing
    }

    public function supportsRememberMe()
    {
        return false;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $error = [
            'error' => [
                'message' => 'Invalid credentials.',
                'detail' => 'Auth header required.',
            ],
        ];

        $serializedError = $this->serializer->serialize($error, $request->getRequestFormat());

        return new Response($serializedError, Response::HTTP_UNAUTHORIZED, [
            'Content-Type' => $this->contentNegotiator->getNegotiatedContentType(),
        ]);
    }
}
