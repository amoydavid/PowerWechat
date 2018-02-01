<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Tests\Kernel;

use PowerWeChat\Kernel\Exceptions\RuntimeException;
use PowerWeChat\Kernel\Support\ArrayAccessible;
use PowerWeChat\Kernel\Support\Collection;
use PowerWeChat\Tests\TestCase;
use function PowerWeChat\Kernel\data_get;
use function PowerWeChat\Kernel\data_to_array;

class HelpersTest extends TestCase
{
    public function testDataGet()
    {
        // array
        $this->assertSame('foo', data_get(['name' => 'foo'], 'name'));
        $this->assertNull(data_get(['name' => 'foo'], 'age'));
        $this->assertSame(27, data_get(['name' => 'foo'], 'age', 27));

        // Arrayable
        $array = new ArrayAccessible(['name' => 'overtrue']);
        $this->assertSame('overtrue', data_get($array, 'name'));

        // ArrayAccess
        $array = new DummyArrayAccessClassForHelpersTest(['name' => 'overtrue']);
        $this->assertSame('overtrue', data_get($array, 'name'));

        // Collection
        $array = new Collection(['name' => 'overtrue']);
        $this->assertSame('overtrue', data_get($array, 'name'));

        // IteratorAggregate
        $array = new DummyIteratorAggregateClassForHelpersTest(['name' => 'overtrue']);
        $this->assertSame('overtrue', data_get($array, 'name'));

        // ArrayIterator
        $array = new DummyIteratorAggregateClassForHelpersTest(['name' => 'overtrue']);
        $this->assertSame('overtrue', data_get($array->getIterator(), 'name'));

        $this->expectException(RuntimeException::class);
        data_get('not an array accessible data', 'foo');

        $this->fail('Failed assert that data_get should throw an exception.');
    }

    public function testDataToArray()
    {
        $array = ['name' => 'overtrue'];
        // array
        $this->assertSame($array, data_to_array($array));

        // Arrayable
        $data = new ArrayAccessible($array);
        $this->assertSame($array, data_to_array($data));

        // Collection
        $data = new Collection($array);
        $this->assertSame($array, data_to_array($data));

        // IteratorAggregate
        $data = new DummyIteratorAggregateClassForHelpersTest($array);
        $this->assertSame($array, data_to_array($data));

        // ArrayIterator
        $data = new DummyIteratorAggregateClassForHelpersTest($array);
        $this->assertSame($array, data_to_array($data->getIterator()));

        $this->expectException(RuntimeException::class);
        data_to_array('not an arrayable data', 'foo');

        $this->fail('Failed assert that data_to_array should throw an exception.');
    }
}

class DummyIteratorAggregateClassForHelpersTest implements \IteratorAggregate
{
    private $array;

    public function __construct($array)
    {
        $this->array = $array;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->array);
    }
}

class DummyArrayAccessClassForHelpersTest implements \ArrayAccess
{
    private $array;

    public function __construct($array)
    {
        $this->array = $array;
    }

    public function offsetExists($offset)
    {
        return isset($this->array[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->array[$offset] ?? null;
    }

    public function offsetSet($offset, $value)
    {
        $this->array[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->array[$offset]);
    }
}
