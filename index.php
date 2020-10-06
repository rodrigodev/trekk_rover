<?php declare(strict_types=1);

require './vendor/autoload.php';

use TrekkRover\Coordinates;
use TrekkRover\GroundControl;
use TrekkRover\MapNavigator;
use TrekkRover\Rover;

$groundControl = new GroundControl();

$map = new MapNavigator($groundControl->readNextInstruction());

while ($instruction = $groundControl->readNextInstruction()) {
    $coordinates = new Coordinates($instruction);

    $rover = new Rover($coordinates, $map);
    $rover->run($groundControl->readNextInstruction());

    $currentCoordinates = $rover->getCurrentPosition();

    printf('%d %d %s' . PHP_EOL,
        $currentCoordinates->getX(),
        $currentCoordinates->getY(),
        $currentCoordinates->getFaceSymbol()
    );
}


