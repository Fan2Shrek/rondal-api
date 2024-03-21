<?php

namespace App\Tests\Functional\Doctrine;

use PHPUnit\Framework\TestCase;
use App\Doctrine\Types\EntityBagType;
use App\Object\Bag\EntityDataBag;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Mockery\MockInterface;

class EntityBagTypeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (!Type::hasType('entityBag')) {
            Type::addType('entityBag', EntityBagType::class);
        }
    }

    /**
     * @dataProvider convert_entitybag_to_php_value
     */
    public function test_convert_entitybag_to_database_value(string $expected, EntityDataBag $bag): void
    {
        $actual = Type::getType('entityBag')->convertToDatabaseValue($bag, $this->getPlatform());

        $this->assertSame($expected, $actual);
    }

    public static function convert_entitybag_to_php_value(): iterable
    {
        yield 'empty' => ['O:28:"App\Object\Bag\EntityDataBag":0:{}', new EntityDataBag()];
        $bag = new EntityDataBag();
        $bag->set('key', 'value');
        yield 'parameter' => ['O:28:"App\Object\Bag\EntityDataBag":1:{s:3:"key";s:5:"value";}', $bag];
    }

    /**
     * @return MockInterface&AbstractPlatform
     */
    private function getPlatform(): MockInterface
    {
        /** @var MockInterface */
        $platform = \Mockery::mock(AbstractPlatform::class);

        $platform->allows('getGuidTypeDeclarationSQL');

        return $platform;
    }
}
