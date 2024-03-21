<?php

namespace App\Doctrine\Types;

use App\Object\Bag\EntityDataBag;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;

class EntityBagType extends Type
{
    public const ENTITY_BAG_NAME = 'dataBagType';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getClobTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): EntityDataBag
    {
        if (!is_string($value)) {
            throw new ConversionException(sprintf('Could not convert "%s" to an instance of "%s".', get_debug_type($value), EntityDataBag::class));
        }

        $value = unserialize($value);

        if (!$value instanceof EntityDataBag) {
            throw new ConversionException(sprintf('Could not convert "%s" is not an instance of "%s".', get_debug_type($value), EntityDataBag::class));
        }

        return $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if (!$value instanceof EntityDataBag) {
            throw new ConversionException(sprintf('%s can only convert object of type "%s" "%s" received.', $this::class, EntityDataBag::class, get_debug_type($value)));
        }

        return serialize($value);
    }

    public function getName()
    {
        return self::ENTITY_BAG_NAME;
    }
}
