<?php

namespace App\Api\Serializer;

use App\Domain\Command\Interface\CurrentResourceAwareInterface;
use App\Entity\Product;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class CurrentResourceDenormalizer implements DenormalizerInterface, DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;

    private const ALREADY_CALLED = 'current_resource_denormalizer_already_called';

    /**
     * @param array{
     *     object_to_populate?: Product,
     * } $context
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        $data = $this->denormalizer->denormalize($data, $type, $format, $context + [self::ALREADY_CALLED => true]);

        if (!isset($context['object_to_populate'])) {
            return $data;
        }

        $data->setCurrentResource($context['object_to_populate']);

        return $data;
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return
            is_subclass_of($type, CurrentResourceAwareInterface::class)
            && false === ($context[self::ALREADY_CALLED] ?? false);
    }

    /**
     * @return array<string, bool>
     */
    public function getSupportedTypes(?string $format): array
    {
        return [
            CurrentResourceAwareInterface::class => false,
        ];
    }
}
