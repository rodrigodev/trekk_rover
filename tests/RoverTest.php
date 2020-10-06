<?php declare(strict_types=1);

namespace TrekkRover;

use PHPUnit\Framework\TestCase;
use RuntimeException;

class RoverTest extends TestCase
{
    public function testCanCreateRover(): void
    {
        $coordinates = $this->createMock(CoordinatesInterface::class);
        $map = $this->createMock(MapNavigatorInterface::class);

        $rover = new Rover($coordinates, $map);
        self::assertInstanceOf(Rover::class, $rover);
    }

    public function testGetCurrentPosition(): void
    {
        $coordinates = $this->createMock(CoordinatesInterface::class);
        $map = $this->createMock(MapNavigatorInterface::class);

        $rover = new Rover($coordinates, $map);

        $coordinates = $rover->getCurrentPosition();
        self::assertNotNull($coordinates);
    }

    public function testRunSuccessfully(): void
    {
        $coordinates = $this->createMock(CoordinatesInterface::class);
        $map = $this->createMock(MapNavigatorInterface::class);
        $map->expects(self::atLeastOnce())
            ->method('checkPosition')
            ->willReturn(true);

        $rover = new Rover($coordinates, $map);
        $rover->run('MLMR');
    }

    public function testMoveOutOfMapBoundaries(): void
    {
        $coordinates = $this->createMock(CoordinatesInterface::class);
        $map = $this->createMock(MapNavigatorInterface::class);
        $map->expects(self::once())
            ->method('checkPosition')
            ->willReturn(false);

        $this->expectException(RuntimeException::class);

        $rover = new Rover($coordinates, $map);
        $rover->run('MLMR');
    }

    public function testRunUnknownCommand(): void
    {
        $coordinates = $this->createMock(CoordinatesInterface::class);
        $map = $this->createMock(MapNavigatorInterface::class);

        $this->expectException(RuntimeException::class);

        $rover = new Rover($coordinates, $map);
        $rover->run('X');
    }
}
