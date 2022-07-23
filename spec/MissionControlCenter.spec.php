<?php

namespace GPascual\MarsRover\Spec;

use GPascual\MarsRover\CardinalPoint;
use GPascual\MarsRover\Coordinates;
use GPascual\MarsRover\MarsRover;
use GPascual\MarsRover\MissionControlCenter;

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
    given('controlCenter', fn() => new MissionControlCenter());

    it('should be created with initial position and orientation', function () {
        $initialPosition = new Coordinates(0, 0);
        $initialOrientation = CardinalPoint::north();

        $rover = new MarsRover($initialPosition, $initialOrientation);

        expect($rover->position())->toEqual($initialPosition);
        expect($rover->orientation())->toEqual($initialOrientation);
    });

    it('may receive a list of commands', function () {
        $rover = new MarsRover(new Coordinates(0, 0), CardinalPoint::south());

        $this->controlCenter->commands($rover, ['l','f', 'l', 'f', 'r', 'b']);

        expect($rover->position())->toEqual(new Coordinates(0, 1));
        expect($rover->orientation())->toEqual('E');
    });

    describe('given a forward command', function () {
        each([
            'when facing north' => [
                new Coordinates(0, 1),
                CardinalPoint::north(),
                new MarsRover(new Coordinates(0, 0), CardinalPoint::north())
            ],
            'when facing east' => [
                new Coordinates(1, 0),
                CardinalPoint::east(),
                new MarsRover(new Coordinates(0, 0), CardinalPoint::east())
            ],
            'when facing south' => [
                new Coordinates(0, -1),
                CardinalPoint::south(),
                new MarsRover(new Coordinates(0, 0), CardinalPoint::south())
            ],
            'when facing west' => [
                new Coordinates(-1, 0),
                CardinalPoint::west(),
                new MarsRover(new Coordinates(0, 0), CardinalPoint::west())
            ],
        ])->it(
            'should move forward on that direction',
            function ($expectedPosition, $expectedOrientation, MarsRover $rover) {
                $this->controlCenter->commands($rover, ['f']);

                expect($rover->position())->toEqual($expectedPosition);
                expect($rover->orientation())->toBe($expectedOrientation);
            }
        );
    });

    describe('given a backward command', function () {
        each([
            'when facing north' => [
                new Coordinates(0, -1),
                CardinalPoint::north(),
                new MarsRover(new Coordinates(0, 0), CardinalPoint::north())
            ],
            'when facing east' => [
                new Coordinates(-1, 0),
                CardinalPoint::east(),
                new MarsRover(new Coordinates(0, 0), CardinalPoint::east())
            ],
            'when facing south' => [
                new Coordinates(0, 1),
                CardinalPoint::south(),
                new MarsRover(new Coordinates(0, 0), CardinalPoint::south())
            ],
            'when facing west' => [
                new Coordinates(1, 0),
                CardinalPoint::west(),
                new MarsRover(new Coordinates(0, 0), CardinalPoint::west())
            ],
        ])->it(
            'should move backward on that direction',
            function ($expectedPosition, $expectedOrientation, MarsRover $rover) {
                $this->controlCenter->commands($rover, ['b']);

                expect($rover->position())->toEqual($expectedPosition);
                expect($rover->orientation())->toBe($expectedOrientation);
            }
        );
    });

    describe('given a left command', function () {
        each([
            'when facing north' => [
                new Coordinates(0, 0),
                CardinalPoint::west(),
                new MarsRover(new Coordinates(0, 0), CardinalPoint::north())
            ],
            'when facing east' => [
                new Coordinates(0, 0),
                CardinalPoint::north(),
                new MarsRover(new Coordinates(0, 0), CardinalPoint::east())
            ],
            'when facing south' => [
                new Coordinates(0, 0),
                CardinalPoint::east(),
                new MarsRover(new Coordinates(0, 0), CardinalPoint::south())
            ],
            'when facing west' => [
                new Coordinates(0, 0),
                CardinalPoint::south(),
                new MarsRover(new Coordinates(0, 0), CardinalPoint::west())
            ],
        ])->it(
            'should turn counterclockwise',
            function ($expectedPosition, $expectedOrientation, MarsRover $rover) {
                $this->controlCenter->commands($rover, ['l']);

                expect($rover->position())->toEqual($expectedPosition);
                expect($rover->orientation())->toBe($expectedOrientation);
            }
        );
    });

    describe('given a right command', function () {
        each([
            'when facing north' => [
                new Coordinates(0, 0),
                CardinalPoint::east(),
                new MarsRover(new Coordinates(0, 0), CardinalPoint::north())
            ],
            'when facing east' => [
                new Coordinates(0, 0),
                CardinalPoint::south(),
                new MarsRover(new Coordinates(0, 0), CardinalPoint::east())
            ],
            'when facing south' => [
                new Coordinates(0, 0),
                CardinalPoint::west(),
                new MarsRover(new Coordinates(0, 0), CardinalPoint::south())
            ],
            'when facing west' => [
                new Coordinates(0, 0),
                CardinalPoint::north(),
                new MarsRover(new Coordinates(0, 0), CardinalPoint::west())
            ],
        ])->it(
            'should turn clockwise',
            function ($expectedPosition, $expectedOrientation, MarsRover $rover) {
                $this->controlCenter->commands($rover, ['r']);

                expect($rover->position())->toEqual($expectedPosition);
                expect($rover->orientation())->toBe($expectedOrientation);
            }
        );
    });
});
