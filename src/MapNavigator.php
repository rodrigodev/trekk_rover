<?php declare(strict_types=1);

namespace TrekkRover;

use RuntimeException;

/**
 * Class MapNavigator
 *
 * @package TrekkRover
 */
final class MapNavigator implements MapNavigatorInterface
{
    /**
     * @var array $terrain
     */
    private array $terrain;

    /**
     * MapNavigator constructor.
     *
     * @param string $instruction
     */
    public function __construct(string $instruction)
    {
        $terrainSizes = explode(' ', $instruction);

        foreach ($terrainSizes as $size) {
            if (!is_numeric($size)) {
                throw new RuntimeException(sprintf('%s is not a valid size', $size));
            }
        }

        for ($i = 0; $i <= (int)$terrainSizes[0]; $i++) {
            $this->terrain[$i] = array_fill(0, (int)$terrainSizes[1], 1);
        }
    }

    /**
     * @param int $x
     * @param int $y
     *
     * @return bool
     */
    public function checkPosition(int $x, int $y): bool
    {
        if ($x < 0 || $y < 0) {
            throw new RuntimeException('The position coordinates cannot be less than 0');
        }

        if (count($this->terrain) === 0) {
            throw new RuntimeException('terrain not initialized');
        }

        return (isset($this->terrain[$x][$y]) && $this->terrain[$x][$y] === 1);
    }
}