<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Entity\Workshop;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

final class WorkshopNormalizer implements ContextAwareNormalizerInterface
{
    public function __construct(
        private ObjectNormalizer $normalizer
    ) {
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Workshop;
    }

    /**
     * @param Workshop $object
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $customContext = [
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['id'],
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => fn ($object, $format, $context) => $object->getTitle(),
        ];

        $context = array_merge($context, $customContext);

        $data = $this->normalizer->normalize($object, $format, $context);

        if (\is_array($data)) {
            $data['workshop_date'] = $object->getWorkshopDate()->format('Y-m-d');
        }

        return $data;
    }
}
