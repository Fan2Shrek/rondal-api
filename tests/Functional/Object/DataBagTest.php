<?php

namespace App\Tests\Functional\Object;

use App\Object\Bag\DataBag;
use App\Object\Bag\Exception\DataNotFoundException;
use PHPUnit\Framework\TestCase;

class DataBagTest extends TestCase
{
    public function test_has(): void
    {
        $bag = new DataBag();
        $bag->set('key', 'value');
        $this->assertTrue($bag->has('key'));
        $this->assertFalse($bag->has('unknown'));
    }

    public function test_get(): void
    {
        $bag = new DataBag();
        $bag->set('key', 'value');
        $this->assertEquals('value', $bag->get('key'));
    }

    public function test_get_unknow_value(): void
    {
        $this->expectException(DataNotFoundException::class);

        $bag = new DataBag();
        $this->assertEquals('value', $bag->get('key'));
    }

    public function test_set(): void
    {
        $bag = new DataBag();
        $bag->set('key', 'value');
        $bag->set('foo', 'bar');
        $this->assertEquals(['key' => 'value', 'foo' => 'bar'], $bag->all());
    }

    public function test_remove(): void
    {
        $bag = new DataBag();
        $bag->set('key', 'value');
        $bag->set('foo', 'bar');
        $bag->remove('key');
        $this->assertEquals(['foo' => 'bar'], $bag->all());
    }

    public function test_clear(): void
    {
        $bag = new DataBag();
        $bag->set('key', 'value');
        $bag->set('foo', 'bar');
        $bag->clear();
        $this->assertEquals([], $bag->all());
    }

    public function test_all(): void
    {
        $bag = new DataBag();
        $bag->set('key', 'value');
        $bag->set('foo', 'bar');
        $this->assertEquals(['key' => 'value', 'foo' => 'bar'], $bag->all());
    }
}
