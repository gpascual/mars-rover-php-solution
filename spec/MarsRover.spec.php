<?php

namespace GPascual\MarsRover\Spec;

use GPascual\MarsRover\MarsRover;

function each($data): object
{
    return new class ($data) {
        private array $data;

        public function __construct(array $data)
        {
            $this->data = $data;
        }

        public function it($message, callable $closure)
        {
            foreach ($this->data as $contextMessage => $datum) {
                $itClosure = function () use ($closure, $datum) {
                    $closure(...$datum);
                };
                $contextClosure = function () use ($message, $itClosure) {
                    it($message, $itClosure);
                };

                if ($contextMessage) {
                    context($contextMessage, $contextClosure);
                } else {
                    $contextClosure();
                }
            }
        }
    };
}

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

        $rover->commands(['f', 'f', 'b', 'f']);

        expect($rover->position())->toBe([-2, 0]);
        expect($rover->orientation())->toBe('S');
    });

    describe('given a forward command', function () {
        each([
            'when facing north' => [[1, 0], 'N', new MarsRover([0, 0], 'N')],
            'when facing east' => [[0, 1], 'E', new MarsRover([0, 0], 'E')],
            'when facing south' => [[-1, 0], 'S', new MarsRover([0, 0], 'S')],
            'when facing west' => [[0, -1], 'W', new MarsRover([0, 0], 'W')],
        ])->it(
            'should move forward on that direction',
            function ($expectedPosition, $expectedOrientation, MarsRover $rover) {
                $rover->commands(['f']);

                expect($rover->position())->toBe($expectedPosition);
                expect($rover->orientation())->toBe($expectedOrientation);
            }
        );
    });

    describe('given a backward command', function () {
        each([
            'when facing north' => [[-1, 0], 'N', new MarsRover([0, 0], 'N')],
            'when facing east' => [[0, -1], 'E', new MarsRover([0, 0], 'E')],
            'when facing south' => [[1, 0], 'S', new MarsRover([0, 0], 'S')],
            'when facing west' => [[0, 1], 'W', new MarsRover([0, 0], 'W')],
        ])->it(
            'should move backward on that direction',
            function ($expectedPosition, $expectedOrientation, MarsRover $rover) {
                $rover->commands(['b']);

                expect($rover->position())->toBe($expectedPosition);
                expect($rover->orientation())->toBe($expectedOrientation);
            }
        );
    });
});
