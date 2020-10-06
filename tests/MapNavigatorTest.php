<?php declare(strict_types=1);

namespace TrekkRover;

use PHPUnit\Framework\TestCase;

class MapNavigatorTest  extends TestCase
{
    public function testCanCreateMapNavigator(): void
    {
        $map = new MapNavigator('5 5');
        self::assertInstanceOf(MapNavigator::class, $map);
    }

    public function testSuccessfullyCheckingPosition(): void
    {
        $testCases = [
            ['x' => 1, 'y' => 0],
            ['x' => 4, 'y' => 2],
            ['x' => 5, 'y' => 1],
            ['x' => 3, 'y' => 3],
            ['x' => 4, 'y' => 4],
        ];

        $map = new MapNavigator('5 5');

        foreach ($testCases as $testCase) {
            self::assertTrue($map->checkPosition($testCase['x'], $testCase['y']));
        }
    }

    public function testErrorCheckingPosition(): void
    {
        $testCases = [
            ['x' => -1, 'y' => 0, 'error' => 'The position coordinates cannot be less than 0'],
            ['x' => 8, 'y' => 2],
            ['x' => 1, 'y' => 6],
        ];

        $map = new MapNavigator('5 5');

        foreach ($testCases as $testCase) {
            if ($testCase['error']) {
                $this->expectExceptionMessage($testCase['error']);
            }
            self::assertFalse($map->checkPosition($testCase['x'], $testCase['y']));
        }
    }
}
