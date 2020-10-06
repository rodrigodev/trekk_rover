<?php declare(strict_types=1);

namespace TrekkRover;

use RuntimeException;

/**
 * Class Coordinates
 *
 * @package TrekkRover
 */
final class Coordinates implements CoordinatesInterface
{
    /**
     * cardinal points
     */
    public const
        NORTH = 'N',
        EAST = 'E',
        SOUTH = 'S',
        WEST = 'W';
    /**
     * @const FACE_MAP
     */
    public const FACE_MAP = [
        self::NORTH => 0,
        self::EAST => 1,
        self::SOUTH => 2,
        self::WEST => 3,
    ];
    private int $x;
    private int $y;
    private int $face;

    /**
     * Coordinates constructor.
     *
     * @param string $instruction
     */
    public function __construct(string $instruction)
    {
        $instruction = trim($instruction);

        if ($instruction === '') {
            throw new RuntimeException('Empty instruction');
        }

        [$x, $y, $face] = explode(' ', $instruction);

        if (!is_numeric($x) || $x < 0) {
            throw new RuntimeException('Provided x position is not valid');
        }

        if (!is_numeric($y) || $y < 0) {
            throw new RuntimeException('Provided y position is not valid');
        }

        if (self::FACE_MAP[$face] === null) {
            throw new RuntimeException('Unknown face provided');
        }

        $this->face = self::FACE_MAP[$face];
        $this->x = (int)$x;
        $this->y = (int)$y;
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @return int
     */
    public function getFace(): int
    {
        return $this->face;
    }

    /**
     * @return string
     */
    public function getFaceSymbol(): string
    {
        return array_flip(self::FACE_MAP)[$this->face];
    }

    /**
     * @param int $x
     * @param int $y
     */
    public function updatePosition(int $x, int $y): void
    {
        if ((abs($x) !== 1 && $y === 0) ||
            (abs($y) !== 1 && $x === 0)) {
            throw new RuntimeException('The position can only be changed by one position at time');
        }

        $this->x += $x;
        $this->y += $y;

        if ($this->x < 0 || $this->y < 0) {
            throw new RuntimeException('Can`t go bellow 0');
        }
    }

    /**
     * @param int $position
     */
    public function updateDirection(int $position): void
    {
        if (abs($position) !== 1) {
            throw new RuntimeException('The direction can only be changed by one position at time');
        }

        $this->face += $position;

        if ($this->face > 4) {
            $this->face -= 4;
        }

        if ($this->face < 0) {
            $this->face += 4;
        }
    }
}