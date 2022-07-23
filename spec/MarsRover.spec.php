<?php

namespace GPascual\MarsRover\Spec;

use GPascual\MarsRover\MarsRover;

describe('A Mars Rover', function () {
    it('should be created with initial position and orientation', function () {
        $initialPosition = [0, 0];
        $initialOrientation = 'N';

        $rover = new MarsRover($initialPosition, $initialOrientation);

        expect($rover->position())->toBe($initialPosition);
        expect($rover->orientation())->toBe($initialOrientation);
    });

    it('may receive a list of commands', function () {
        $rover = new MarsRover([0, 0], 'S');

        $rover->commands([]);

        expect($rover->position())->toBe([0, 0]);
        expect($rover->orientation())->toBe('S');
    });
});
