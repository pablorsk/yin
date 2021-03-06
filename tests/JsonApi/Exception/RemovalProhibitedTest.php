<?php
declare(strict_types=1);

namespace WoohooLabs\Yin\Tests\JsonApi\Exception;

use PHPUnit\Framework\TestCase;
use WoohooLabs\Yin\JsonApi\Exception\RemovalProhibited;

class RemovalProhibitedTest extends TestCase
{
    /**
     * @test
     */
    public function getRelationshipName()
    {
        $relationshipName = "authors";

        $exception = $this->createException($relationshipName);
        $this->assertEquals($relationshipName, $exception->getRelationshipName());
    }

    private function createException(string $relationshipName): RemovalProhibited
    {
        return new RemovalProhibited($relationshipName);
    }
}
