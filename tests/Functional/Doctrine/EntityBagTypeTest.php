<?php

namespace App\Tests\Functional\Doctrine;

use App\Doctrine\Types\EntityBagType;
use App\Object\Bag\EntityDataBag;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

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
     * @dataProvider entitybag_to_php_value
     */
    public function test_convert_entitybag_to_database_value(string $expected, EntityDataBag $bag): void
    {
        $actual = Type::getType('entityBag')->convertToDatabaseValue($bag, $this->getPlatform());

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider entitybag_to_php_value
     */
    public function test_convert_database_value_to_entitybag(string $databaseValue, EntityDataBag $expected): void
    {
        $actual = Type::getType('entityBag')->convertToPHPValue($databaseValue, $this->getPlatform());

        $this->assertEquals($expected, $actual);
    }

    public static function entitybag_to_php_value(): iterable
    {
        yield 'empty' => ['O:28:"App\Object\Bag\EntityDataBag":0:{}', new EntityDataBag()];

        $bag = new EntityDataBag();
        $bag->set('key', 'value');
        yield 'parameter' => ['O:28:"App\Object\Bag\EntityDataBag":1:{s:3:"key";s:5:"value";}', $bag];

        $bag = new EntityDataBag();
        $bag->set('key', 'value');
        $bag->set('true', true);
        $bag->set('false', false);
        $bag->set('one', 1);
        yield 'complete_parameter' => ['O:28:"App\Object\Bag\EntityDataBag":4:{s:3:"key";s:5:"value";s:4:"true";b:1;s:5:"false";b:0;s:3:"one";i:1;}', $bag];
    }

    public function test_get_sql_declaration(): void
    {
        $this->assertEquals('GUID', Type::getType('entityBag')->getSQLDeclaration([], $this->getPlatform()));
    }

    public function test_convert_wrong_value_to_php_value(): void
    {
        $this->expectException(ConversionException::class);

        Type::getType('entityBag')->convertToPHPValue('bad_value', $this->getPlatform());
    }

    public function test_convert_wrong_value_to_database_value(): void
    {
        $this->expectException(ConversionException::class);

        Type::getType('entityBag')->convertToDatabaseValue(new \stdClass(), $this->getPlatform());
    }

    /**
     * @return MockInterface&AbstractPlatform
     */
    private function getPlatform(): MockInterface
    {
        /** @var MockInterface */
        $platform = \Mockery::mock(AbstractPlatform::class);

        $platform->allows('getClobTypeDeclarationSQL')->andReturn('GUID');

        return $platform;
    }
}
