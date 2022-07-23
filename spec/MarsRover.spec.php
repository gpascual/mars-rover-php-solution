<?php

namespace GPascual\MarsRover\Spec;

use GPascual\MarsRover\Coordinates;
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
        $initialPosition = new Coordinates(0, 0);
        $initialOrientation = 'N';

        $rover = new MarsRover($initialPosition, $initialOrientation);

        expect($rover->position())->toEqual($initialPosition);
        expect($rover->orientation())->toBe($initialOrientation);
    });

    it('may receive a list of commands', function () {
        $rover = new MarsRover(new Coordinates(0, 0), 'S');

        $rover->commands(['l','f', 'l', 'f', 'r', 'b']);

        expect($rover->position())->toEqual(new Coordinates(0, 1));
        expect($rover->orientation())->toBe('E');
    });

    describe('given a forward command', function () {
        each([
            'when facing north' => [new Coordinates(0, 1), 'N', new MarsRover(new Coordinates(0, 0), 'N')],
            'when facing east' => [new Coordinates(1, 0), 'E', new MarsRover(new Coordinates(0, 0), 'E')],
            'when facing south' => [new Coordinates(0, -1), 'S', new MarsRover(new Coordinates(0, 0), 'S')],
            'when facing west' => [new Coordinates(-1, 0), 'W', new MarsRover(new Coordinates(0, 0), 'W')],
        ])->it(
            'should move forward on that direction',
            function ($expectedPosition, $expectedOrientation, MarsRover $rover) {
                $rover->commands(['f']);

                expect($rover->position())->toEqual($expectedPosition);
                expect($rover->orientation())->toBe($expectedOrientation);
            }
        );
    });

    describe('given a backward command', function () {
        each([
            'when facing north' => [new Coordinates(0, -1), 'N', new MarsRover(new Coordinates(0, 0), 'N')],
            'when facing east' => [new Coordinates(-1, 0), 'E', new MarsRover(new Coordinates(0, 0), 'E')],
            'when facing south' => [new Coordinates(0, 1), 'S', new MarsRover(new Coordinates(0, 0), 'S')],
            'when facing west' => [new Coordinates(1, 0), 'W', new MarsRover(new Coordinates(0, 0), 'W')],
        ])->it(
            'should move backward on that direction',
            function ($expectedPosition, $expectedOrientation, MarsRover $rover) {
                $rover->commands(['b']);

                expect($rover->position())->toEqual($expectedPosition);
                expect($rover->orientation())->toBe($expectedOrientation);
            }
        );
    });

    describe('given a left command', function () {
        each([
            'when facing north' => [new Coordinates(0, 0), 'W', new MarsRover(new Coordinates(0, 0), 'N')],
            'when facing east' => [new Coordinates(0, 0), 'N', new MarsRover(new Coordinates(0, 0), 'E')],
            'when facing south' => [new Coordinates(0, 0), 'E', new MarsRover(new Coordinates(0, 0), 'S')],
            'when facing west' => [new Coordinates(0, 0), 'S', new MarsRover(new Coordinates(0, 0), 'W')],
        ])->it(
            'should turn counterclockwise',
            function ($expectedPosition, $expectedOrientation, MarsRover $rover) {
                $rover->commands(['l']);

                expect($rover->position())->toEqual($expectedPosition);
                expect($rover->orientation())->toBe($expectedOrientation);
            }
        );
    });

    describe('given a right command', function () {
        each([
            'when facing north' => [new Coordinates(0, 0), 'E', new MarsRover(new Coordinates(0, 0), 'N')],
            'when facing east' => [new Coordinates(0, 0), 'S', new MarsRover(new Coordinates(0, 0), 'E')],
            'when facing south' => [new Coordinates(0, 0), 'W', new MarsRover(new Coordinates(0, 0), 'S')],
            'when facing west' => [new Coordinates(0, 0), 'N', new MarsRover(new Coordinates(0, 0), 'W')],
        ])->it(
            'should turn clockwise',
            function ($expectedPosition, $expectedOrientation, MarsRover $rover) {
                $rover->commands(['r']);

                expect($rover->position())->toEqual($expectedPosition);
                expect($rover->orientation())->toBe($expectedOrientation);
            }
        );
    });
});
