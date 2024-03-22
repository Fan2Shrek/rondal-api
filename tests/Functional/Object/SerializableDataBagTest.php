<?php

namespace App\Tests\Functional\Object;

use PHPUnit\Framework\TestCase;
use App\Object\Bag\SerializableDataBag;

class SerializableDataBagTest extends TestCase
{
    /**
     * @dataProvider serialize_provider
     */
    public function test_serialize(string $expected, SerializableDataBag $bag): void
    {
        $this->assertEquals($expected, serialize($bag));
    }

    /**
     * @dataProvider serialize_provider
     */
    public function test_unserialize(string $initial, SerializableDataBag $expected): void
    {
        $this->assertEquals($expected, unserialize($initial));
    }

    public static function serialize_provider(): iterable
    {
        $bag = new SerializableDataBag();
        $bag->set('key', 'value');

        yield 'empty' => ['O:34:"App\Object\Bag\SerializableDataBag":1:{s:3:"key";s:5:"value";}', $bag];
    }

    /**
     * @dataProvider json_serialize_provider
     */
    public function test_json_serialize(string $expected, SerializableDataBag $bag): void
    {
        $this->assertEquals($expected, json_encode($bag));
    }

    public static function json_serialize_provider(): iterable
    {
        $bag = new SerializableDataBag();
        $bag->set('key', 'value');

        yield 'empty' => ['{"key":"value"}', $bag];
    }
}
