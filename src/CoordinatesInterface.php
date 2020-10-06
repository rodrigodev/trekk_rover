<?php

namespace TrekkRover;


/**
 * Class Coordinates
 *
 * @package TrekkRover
 */
interface CoordinatesInterface
{
    /**
     * @return int
     */
    public function getX(): int;

    /**
     * @return int
     */
    public function getY(): int;

    /**
     * @return int
     */
    public function getFace(): int;

    /**
     * @return string
     */
    public function getFaceSymbol(): string;

    /**
     * @param int $x
     * @param int $y
     */
    public function updatePosition(int $x, int $y): void;

    /**
     * @param int $position
     */
    public function updateDirection(int $position): void;
}