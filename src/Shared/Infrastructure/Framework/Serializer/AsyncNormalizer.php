<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Framework\Serializer;

use Shared\Domain\Messaging\AsyncMessage;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class AsyncNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function normalize($object, $format = null, array $context = [])
    {
        return $object->toArrayOfPlainValues();
    }

    public function supportsNormalization($data, $format = null)
    {
        return $this->support($data);
    }

    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return $class::fromArray($data);
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return $this->support($type);
    }

    private function support($data): bool
    {
        return is_a($data, AsyncMessage::class, true);
    }
}
