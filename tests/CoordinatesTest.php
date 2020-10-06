<?php declare(strict_types=1);

namespace TrekkRover;

use PHPUnit\Framework\TestCase;
use RuntimeException;

class CoordinatesTest extends TestCase
{
    public function testCanCreateCoordinates(): void
    {
        $testCases = [
            '0 0 N',
            '1 5 E',
            '4 3 W',
            '9 1 S',
            '99 85 N',
        ];

        foreach ($testCases as $testCase) {
            $coordinates = new Coordinates($testCase);
            self::assertInstanceOf(Coordinates::class, $coordinates);
        }
    }

    public function testBadCoordinatesInstruction(): void
    {
        $testCases = [
            [
                'instruction' => '',
                'expected' => RuntimeException::class,
                'message' => 'Empty instruction',
            ],
            [
                'instruction' => '-1 0 N',
                'expected' => RuntimeException::class,
                'message' => 'Provided x position is not valid',
            ],
            [
                'instruction' => '0 -1 N',
                'expected' => RuntimeException::class,
                'message' => 'Provided y position is not valid',
            ],
            [
                'instruction' => '00N',
                'expected' => RuntimeException::class,
                'message' => 'Provided x position is not valid',
            ],
            [
                'instruction' => '0',
                'expected' => RuntimeException::class,
                'message' => 'Provided y position is not valid',
            ],
            [
                'instruction' => '0 0 X',
                'expected' => RuntimeException::class,
                'message' => 'Unknown face provided',
            ],
        ];

        foreach ($testCases as $testCase) {
            $this->expectException($testCase['expected']);
            $this->expectExceptionMessage($testCase['message']);

            $_ = new Coordinates($testCase['instruction']);
        }
    }

    public function testUpdateDirection(): void
    {
        $coordinates = new Coordinates('0 0 N');
        $coordinates->updateDirection(1);

        self::assertEquals(1, $coordinates->getFace());
        self::assertEquals('E', $coordinates->getFaceSymbol());

        $coordinates->updateDirection(-1);

        self::assertEquals(0, $coordinates->getFace());
        self::assertEquals('N', $coordinates->getFaceSymbol());

        $coordinates->updateDirection(-1);

        self::assertEquals(3, $coordinates->getFace());
        self::assertEquals('W', $coordinates->getFaceSymbol());

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The direction can only be changed by one position at time');

        $coordinates->updateDirection(2);
    }

    public function testUpdatePosition(): void
    {
        $coordinates = new Coordinates('0 0 N');

        $coordinates->updatePosition(1, 0);
        self::assertEquals(1, $coordinates->getX());

        $coordinates->updatePosition(0, 1);
        self::assertEquals(1, $coordinates->getY());

        $coordinates->updatePosition(0, -1);
        self::assertEquals(0, $coordinates->getY());

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The position can only be changed by one position at time');

        $coordinates->updatePosition(2, 0);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The position can only be changed by one position at time');

        $coordinates->updatePosition(1, 1);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Can`t go bellow 0');

        $coordinates->updatePosition(0, -1);
    }
}
