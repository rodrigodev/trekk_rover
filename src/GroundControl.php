<?php declare(strict_types=1);

namespace TrekkRover;

use Iterator;

/**
 * Class GroundControl
 *
 * @package TrekkRover
 */
final class GroundControl
{
    /**
     * @var Iterator $instructionProvider
     */
    private Iterator $instructionProvider;

    /**
     * GroundControl constructor.
     *
     * @param Iterator|null $instructionProvider
     */
    public function __construct(Iterator $instructionProvider = null)
    {
        if ($instructionProvider) {
            $this->instructionProvider = $instructionProvider;
        } else {
            $this->instructionProvider = $this->instructionReaderGenerator();
        }
    }

    /**
     * @return Iterator
     */
    private function instructionReaderGenerator(): Iterator
    {
        while ($line = fgets(STDIN)) {
            yield is_string($line) ? trim($line) : $line;
        }
    }

    /**
     * @return string|null
     */
    public function readNextInstruction(): ?string
    {
        $current = $this->instructionProvider->current();
        $this->instructionProvider->next();
        return $current;
    }
}