<?php

namespace Madkom\ES\Banking\UI\Bundle\ORM\Type;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Madkom\ES\Banking\UI\Bundle\App\Serializer;

/**
 * Class Transfer
 * @package Madkom\ES\Banking\UI\Bundle\ORM\Type
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class TransferType extends Type
{

    const TRANSFER = 'transfer';

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return self::TRANSFER;
    }

    /**
     * @inheritDoc
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'JSONB';
    }

    public function convertToPHPValue($value, AbstractPlatform $abstractPlatform)
    {
        if(!$value) {
            return [];
        }

        $serializer = Serializer::getInstance();
        $transfers  = $serializer->deserialize($value, 'array<Madkom\ES\Banking\Domain\Account\Transfer>', 'json');

        return new ArrayCollection($transfers);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $abstractPlatform)
    {
        if(!$value) {
            return null;
        }

        $serializer = Serializer::getInstance();

        return $serializer->serialize($value, 'json');
    }

}