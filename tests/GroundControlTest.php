<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use TrekkRover\GroundControl;

/**
 * Class GroundControlTest
 */
final class GroundControlTest extends TestCase
{
    public function testGroundControlCanBeCreated(): void
    {
        self::assertInstanceOf(
            GroundControl::class,
            new GroundControl()
        );
    }

    public function testCanPullInstructionsFromGenerator(): void
    {
        $groundControl = new GroundControl($this->gen());
        self::assertEquals($groundControl->readNextInstruction(), '5 5');
        self::assertEquals($groundControl->readNextInstruction(), '');
        self::assertNull($groundControl->readNextInstruction());

    }

    private function gen(): Iterator
    {
        yield '5 5';
        yield '';
        yield null;
    }
}
