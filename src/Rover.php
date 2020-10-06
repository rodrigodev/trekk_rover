<?php declare(strict_types=1);

namespace TrekkRover;

use RuntimeException;

/**
 * Class Rover
 *
 * @package TrekkRover
 */
final class Rover
{
    /**
     * @var CoordinatesInterface $coordinates
     */
    private CoordinatesInterface $coordinates;

    /**
     * @var MapNavigatorInterface $map
     */
    private MapNavigatorInterface $map;

    /**
     * available commands
     */
    private const
        LEFT = 'L',
        RIGHT = 'R',
        MOVE = 'M';


    /**
     * Rover constructor.
     *
     * @param CoordinatesInterface $coordinates
     * @param MapNavigatorInterface $map
     */
    public function __construct(CoordinatesInterface $coordinates, MapNavigatorInterface $map)
    {
        $this->map = $map;
        $this->coordinates = $coordinates;
    }

    public function run(string $instructions): void
    {
        $length = strlen($instructions);
        for ($i = 0; $i < $length; $i++) {
            $this->processInstruction($instructions[$i]);
        }
    }

    /**
     * @param string $command
     */
    private function processInstruction(string $command): void
    {
        if (in_array($command, [self::RIGHT, self::LEFT], true)) {
            $this->turn($command);
            return;
        }
        
        if ($command === self::MOVE) {
            $this->move();
            return;
        }
        
        throw new RuntimeException(sprintf('Unknown command: %s', $command));
    }

    /**
     * @param string $command
     */
    private function turn(string $command): void
    {
        if ($command === self::LEFT) {
            $this->coordinates->updateDirection(-1);
        }

        if ($command === self::RIGHT) {
            $this->coordinates->updateDirection(1);
        }
    }

    /**
     * Moves the rover forward
     */
    private function move(): void
    {
        if ($this->coordinates->getFace() === Coordinates::FACE_MAP[Coordinates::NORTH]) {
            $this->coordinates->updatePosition(0, 1);
        }

        if ($this->coordinates->getFace() === Coordinates::FACE_MAP[Coordinates::EAST]) {
            $this->coordinates->updatePosition(1, 0);
        }

        if ($this->coordinates->getFace() === Coordinates::FACE_MAP[Coordinates::SOUTH]) {
            $this->coordinates->updatePosition(0, -1);
        }

        if ($this->coordinates->getFace() === Coordinates::FACE_MAP[Coordinates::WEST]) {
            $this->coordinates->updatePosition(-1, 0);
        }

        if (!$this->map->checkPosition($this->coordinates->getX(), $this->coordinates->getY())) {
            throw new RuntimeException('The rover fell into a blind spot');
        }
    }

    /**
     * @return CoordinatesInterface
     */
    public function getCurrentPosition(): CoordinatesInterface
    {
        return $this->coordinates;
    }
}