<?php
namespace GPascual\MarsRover\Spec;

use GPascual\MarsRover\MarsRover;

describe('A Mars Rover', function() {
    it('should be created with initial position and orientation', function() {
        $initialPosition = [0, 0];
        $initialOrientation = 'N';

        $rover = new MarsRover($initialPosition, $initialOrientation);

        expect($rover->position())->toBe($initialPosition);
        expect($rover->orientation())->toBe($initialOrientation);
    });
});
