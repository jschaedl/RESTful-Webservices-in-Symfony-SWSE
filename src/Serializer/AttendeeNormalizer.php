<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Entity\Attendee;
use App\Negotiation\ContentNegotiator;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

final class AttendeeNormalizer implements ContextAwareNormalizerInterface
{
    public function __construct(
        private ObjectNormalizer $normalizer,
        private UrlGeneratorInterface $urlGenerator,
        private ContentNegotiator $contentNegotiator,
        private RequestStack $requestStack,
    ) {
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Attendee;
    }

    /**
     * @param Attendee $object
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $customContext = [
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['id'],
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => fn ($object, $format, $context) => $object->getFirstname().' '.$object->getLastname(),
        ];

        $context = array_merge($context, $customContext);

        $data = $this->normalizer->normalize($object, $format, $context);

        if (!is_array($data)) {
            return $data;
        }

        if ($this->contentNegotiator->isNegotiatedContentTypeJsonHal()) {
            $data['_links']['self']['href'] = $this->urlGenerator->generate('read_attendee', [
                'identifier' => $object->getIdentifier(),
            ]);

            $data['_links']['collection']['href'] = $this->urlGenerator->generate('list_attendee');
        }

        return $data;
    }
}