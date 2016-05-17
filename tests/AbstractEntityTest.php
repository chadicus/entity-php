<?php

namespace ChadicusTest\Entity;

use Chadicus\Entity\AbstractEntity;

/**
 * @coversDefaultClass \Chadicus\Entity\AbstractEntity
 * @covers ::<private>
 * @covers ::__construct
 */
final class AbstractEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Verify basic behavior of __get().
     *
     * @test
     * @covers ::__get
     *
     * @return void
     */
    public function magicGet()
    {
        $entity = new SimpleEntity(
            [
                'stringField' => 'abc',
                'boolField' => 'true',
                'intField' => '123',
                'extraField' => 'foo'
            ]
        );

        $this->assertSame('abc', $entity->stringField);
        $this->assertSame(true, $entity->boolField);
        $this->assertSame(123, $entity->intField);
    }

    /**
     * Verify behavior of __get() when the requested property does not exist.
     *
     * @test
     * @covers ::__get
     * @expectedException \Chadicus\Spl\Exceptions\UndefinedPropertyException
     * @expectedExceptionMessage Undefined Property ChadicusTest\Entity\SimpleEntity::$foo
     *
     * @return void
     */
    public function magicGetWithNonExistantProperty()
    {
        (new SimpleEntity([]))->foo;
    }

    /**
     * Verify basic behavior of fromArray().
     *
     * @test
     * @covers ::fromArray
     *
     * @return void
     */
    public function fromArray()
    {
        $entity = SimpleEntity::fromArray(
            [
                'stringField' => 'abc',
                'boolField' => 'true',
                'intField' => '123',
                'extraField' => 'foo'
            ]
        );

        $this->assertSame('abc', $entity->stringField);
        $this->assertSame(true, $entity->boolField);
        $this->assertSame(123, $entity->intField);
    }

    /**
     * Verify basic behavior of fromArrays().
     *
     * @test
     * @covers ::fromArrays
     *
     * @return void
     */
    public function fromArrays()
    {
        $entities = SimpleEntity::fromArrays(
            [
                [
                    'stringField' => 'abc',
                    'boolField' => 'true',
                    'intField' => '123',
                    'extraField' => 'foo'
                ],
                [
                    'stringField' => 'xyz',
                    'boolField' => 'false',
                    'intField' => '890',
                    'extraField' => 'bar'
                ],
            ]
        );

        $this->assertSame('abc', $entities[0]->stringField);
        $this->assertSame(true, $entities[0]->boolField);
        $this->assertSame(123, $entities[0]->intField);
        $this->assertSame('xyz', $entities[1]->stringField);
        $this->assertSame(false, $entities[1]->boolField);
        $this->assertSame(890, $entities[1]->intField);
    }

    /**
     * Verify basic behavior of __call().
     *
     * @test
     * @covers ::__call
     *
     * @return void
     */
    public function magicCall()
    {
        $entity = new SimpleEntity(
            [
                'stringField' => 'abc',
                'boolField' => 'true',
                'intField' => '123',
                'extraField' => 'foo'
            ]
        );

        $this->assertSame('abc', $entity->getStringField());
        $this->assertSame(true, $entity->getBoolField());
        $this->assertSame(123, $entity->getIntField());
    }

    /**
     * Verify behavior of __call() when the requested property does not exist.
     *
     * @test
     * @covers ::__call
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Method ChadicusTest\Entity\SimpleEntity::setFoo() does not exist
     *
     * @return void
     */
    public function magicCallWithNonExistantMethod()
    {
        (new SimpleEntity([]))->setFoo('foo');
    }

    /**
     * Verify behavior of __call() when the requested property does not exist.
     *
     * @test
     * @covers ::__call
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Method ChadicusTest\Entity\SimpleEntity::getFoo() does not exist
     *
     * @return void
     */
    public function magicCallWithNonExistantProperty()
    {
        (new SimpleEntity([]))->getFoo();
    }

    /**
     * Verify basic behavior of jsonSerialize().
     *
     * @test
     * @covers ::jsonSerialize
     *
     * @return void
     */
    public function jsonSerialize()
    {
        $entity = new SimpleEntity(
            [
                'stringField' => 'abc',
                'boolField' => 'true',
                'intField' => '123',
            ]
        );

        $this->assertSame(
            json_encode(
                [
                    'stringField' => 'abc',
                    'boolField' => true,
                    'intField' => 123,
                ]
            ),
            json_encode($entity)
        );

    }
}


