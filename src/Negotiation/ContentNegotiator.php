<?php

declare(strict_types=1);

namespace App\Negotiation;

use Negotiation\Negotiator;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class ContentNegotiator
{
    private const ACCEPTED_CONTENT_TYPES = [
        'application/hal+json',
        'application/json',
        'text/xml',
    ];

    private Negotiator $negotiator;

    public function __construct(
        private RequestStack $requestStack,
    ) {
        $this->negotiator = new Negotiator();
    }

    public function isNegotiatedContentTypeJsonHal(): bool
    {
        return 'application/hal+json' === $this->getNegotiatedContentType();
    }

    public function getNegotiatedRequestFormat(): string
    {
        $contentType = $this->getNegotiatedContentType();

        $contentTypeSplitted = explode('/', $contentType);
        $format = end($contentTypeSplitted);
        $formatSplitted = explode('+', $format);

        return end($formatSplitted);
    }

    public function getNegotiatedContentType(): string
    {
        $acceptableContentTypes = $this->requestStack->getCurrentRequest()->getAcceptableContentTypes();

        if (empty($acceptableContentTypes)) {
            return 'application/hal+json';
        }

        if (1 === count($acceptableContentTypes) && '*/*' === $acceptableContentTypes[0]) {
            return 'application/hal+json';
        }

        $acceptableContentTypesAsString = implode(',', $acceptableContentTypes);
        $acceptHeader = $this->negotiator->getBest($acceptableContentTypesAsString, self::ACCEPTED_CONTENT_TYPES);
        if (null === $acceptHeader) {
            throw new HttpException(415, sprintf('Media Types: %s not supported. Supported Media Types are: %s', $acceptableContentTypesAsString, implode(',', self::ACCEPTED_CONTENT_TYPES)));
        }

        return $acceptHeader->getType();
    }
}
