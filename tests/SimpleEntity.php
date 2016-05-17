<?php

namespace ChadicusTest\Entity;

use Chadicus\Entity\AbstractEntity;
use Chadicus\Entity\EntityInterface;

/**
 * Stub implementation for Abstract entity to be used with unit tests.
 */
final class SimpleEntity extends AbstractEntity implements EntityInterface
{
    /**
     * @see AbstractEntity::getFilters()
     *
     * @return array
     */
    protected function getFilters()
    {
        return [
            'stringField' => [['string']],
            'boolField' => [['bool']],
            'intField' => [['int']],
        ];
    }
}
