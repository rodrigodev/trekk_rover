<?php

namespace TrekkRover;


/**
 * Class MapNavigator
 *
 * @package TrekkRover
 */
interface MapNavigatorInterface
{
    /**
     * @param int $x
     * @param int $y
     *
     * @return bool
     */
    public function checkPosition(int $x, int $y): bool;
}