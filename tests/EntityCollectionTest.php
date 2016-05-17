<?php

namespace ChadicusTest\Entity;

use Chadicus\Entity\EntityCollection;

/**
 * @coversDefaultClass \Chadicus\Entity\EntityCollection
 */
final class EntityCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Verify basic behavior of offsetSet().
     *
     * @test
     * @covers ::offsetSet
     * @covers ::jsonSerialize
     *
     * @return void
     */
    public function offsetSet()
    {
        $collection = new EntityCollection();
        $entityOne = new SimpleEntity(['stringField' => 'abc']);
        $entityTwo = new SimpleEntity(['stringField' => 'xyz']);

        $collection[] = $entityOne;
        $collection[1] = $entityTwo;

        $this->assertSame([$entityOne, $entityTwo], $collection->jsonSerialize());
    }

    /**
     * Verify basic behavior of offsetExists().
     *
     * @test
     * @covers ::offsetExists
     *
     * @return void
     */
    public function offsetExists()
    {
        $collection = new EntityCollection();
        $collection[] = new SimpleEntity(['stringField' => 'abc']);

        $this->assertFalse(isset($collection['foo']));
        $this->assertTrue(isset($collection['0']));
        $this->assertFalse(isset($collection[1]));
    }

    /**
     * Verify basic behavior of offsetUnset().
     *
     * @test
     * @covers ::offsetUnset
     * @covers ::jsonSerialize
     *
     * @return void
     */
    public function offsetUnset()
    {
        $collection = new EntityCollection();
        $entityOne = new SimpleEntity(['stringField' => 'abc']);
        $entityTwo = new SimpleEntity(['stringField' => 'xyz']);

        $collection[] = $entityOne;
        $collection[1] = $entityTwo;

        unset($collection['0']);
        unset($collection['foo']);
        unset($collection[2]);

        $this->assertSame([1 => $entityTwo], $collection->jsonSerialize());
    }

    /**
     * Verify basic behavior of offsetGet().
     *
     * @test
     * @covers ::offsetGet
     *
     * @return void
     */
    public function offsetGet()
    {
        $collection = new EntityCollection();
        $entityOne = new SimpleEntity(['stringField' => 'abc']);
        $entityTwo = new SimpleEntity(['stringField' => 'xyz']);

        $collection[] = $entityOne;
        $collection[] = $entityTwo;

        $this->assertSame($entityOne, $collection['0']);
        $this->assertSame($entityTwo, $collection[1]);
        $this->assertNull($collection['foo']);
        $this->assertNull($collection[2]);
    }
}
