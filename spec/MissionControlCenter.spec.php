<?php

namespace GPascual\MarsRover\Spec;

use GPascual\MarsRover\CardinalPoint;
use GPascual\MarsRover\Coordinates;
use GPascual\MarsRover\MarsRover;
use GPascual\MarsRover\MissionControlCenter;
use GPascual\MarsRover\Planet;

use function Lambdish\Phunctional\each as walk;
use function Lambdish\Phunctional\partial;

function each($data): object
{
    return new class ($data) {
        private array $data;

        public function __construct(array $data)
        {
            $this->data = $data;
        }

        public function it($message, callable $closure): void
        {
            $closureExecutor = partial(
                function ($message, $closure, $datum, $contextMessage) {
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
                },
                $message,
                $closure
            );
            walk($closureExecutor, $this->data);
        }
    };
}

describe('A Mars Rover', function () {
    given('controlCenter', fn() => new MissionControlCenter());
    given('planet', fn() => new Planet(100, 100));

    it('should be created with initial position and orientation', function () {
        $initialPosition = Coordinates::create(0, 0);
        $initialOrientation = CardinalPoint::north();

        $rover = new MarsRover($initialPosition, $initialOrientation);

        expect($rover->position())->toEqual($initialPosition);
        expect($rover->orientation())->toEqual($initialOrientation);
    });

    it('may receive a list of commands', function () {
        $rover = new MarsRover(Coordinates::create(0, 0), CardinalPoint::south());

        $this->controlCenter->commands($rover, $this->planet, ['l','f', 'l', 'f', 'r', 'b']);

        expect($rover->position())->toEqual(Coordinates::create(0, 1));
        expect($rover->orientation())->toBe(CardinalPoint::east());
    });

    describe('given a forward command', function () {
        each([
            'when facing north' => [
                Coordinates::create(1, 2),
                CardinalPoint::north(),
                new MarsRover(Coordinates::create(1, 1), CardinalPoint::north())
            ],
            'when facing east' => [
                Coordinates::create(2, 1),
                CardinalPoint::east(),
                new MarsRover(Coordinates::create(1, 1), CardinalPoint::east())
            ],
            'when facing south' => [
                Coordinates::create(1, 0),
                CardinalPoint::south(),
                new MarsRover(Coordinates::create(1, 1), CardinalPoint::south())
            ],
            'when facing west' => [
                Coordinates::create(0, 1),
                CardinalPoint::west(),
                new MarsRover(Coordinates::create(1, 1), CardinalPoint::west())
            ],
        ])->it(
            'should move forward on that direction',
            function ($expectedPosition, $expectedOrientation, MarsRover $rover) {
                $this->controlCenter->commands($rover, $this->planet, ['f']);

                expect($rover->position())->toEqual($expectedPosition);
                expect($rover->orientation())->toBe($expectedOrientation);
            }
        );

        each([
            'when facing north at the highest latitude'
                => [Coordinates::create(4, 0), new MarsRover(Coordinates::create(4, 5), CardinalPoint::north())],
            'when facing east at the highest longitude'
            => [Coordinates::create(0, 0), new MarsRover(Coordinates::create(5, 0), CardinalPoint::east())],
            'when facing south at the lowest latitude'
            => [Coordinates::create(2, 5), new MarsRover(Coordinates::create(2, 0), CardinalPoint::south())],
            'when facing west at the lowest longitude'
            => [Coordinates::create(5, 1), new MarsRover(Coordinates::create(0, 1), CardinalPoint::west())],
        ])->it(
            'should wrap the edge',
            function (Coordinates $expectedPosition, MarsRover $rover) {
                $this->controlCenter->commands($rover, new Planet(5, 5), ['f']);

                expect($rover->position())->toBe($expectedPosition);
            }
        );
    });

    describe('given a backward command', function () {
        each([
            'when facing north' => [
                Coordinates::create(1, 0),
                CardinalPoint::north(),
                new MarsRover(Coordinates::create(1, 1), CardinalPoint::north())
            ],
            'when facing east' => [
                Coordinates::create(0, 1),
                CardinalPoint::east(),
                new MarsRover(Coordinates::create(1, 1), CardinalPoint::east())
            ],
            'when facing south' => [
                Coordinates::create(1, 2),
                CardinalPoint::south(),
                new MarsRover(Coordinates::create(1, 1), CardinalPoint::south())
            ],
            'when facing west' => [
                Coordinates::create(2, 1),
                CardinalPoint::west(),
                new MarsRover(Coordinates::create(1, 1), CardinalPoint::west())
            ],
        ])->it(
            'should move backward on that direction',
            function ($expectedPosition, $expectedOrientation, MarsRover $rover) {
                $this->controlCenter->commands($rover, $this->planet, ['b']);

                expect($rover->position())->toEqual($expectedPosition);
                expect($rover->orientation())->toBe($expectedOrientation);
            }
        );
    });

    describe('given a left command', function () {
        each([
            'when facing north' => [
                Coordinates::create(0, 0),
                CardinalPoint::west(),
                new MarsRover(Coordinates::create(0, 0), CardinalPoint::north())
            ],
            'when facing east' => [
                Coordinates::create(0, 0),
                CardinalPoint::north(),
                new MarsRover(Coordinates::create(0, 0), CardinalPoint::east())
            ],
            'when facing south' => [
                Coordinates::create(0, 0),
                CardinalPoint::east(),
                new MarsRover(Coordinates::create(0, 0), CardinalPoint::south())
            ],
            'when facing west' => [
                Coordinates::create(0, 0),
                CardinalPoint::south(),
                new MarsRover(Coordinates::create(0, 0), CardinalPoint::west())
            ],
        ])->it(
            'should turn counterclockwise',
            function ($expectedPosition, $expectedOrientation, MarsRover $rover) {
                $this->controlCenter->commands($rover, $this->planet, ['l']);

                expect($rover->position())->toEqual($expectedPosition);
                expect($rover->orientation())->toBe($expectedOrientation);
            }
        );
    });

    describe('given a right command', function () {
        each([
            'when facing north' => [
                Coordinates::create(0, 0),
                CardinalPoint::east(),
                new MarsRover(Coordinates::create(0, 0), CardinalPoint::north())
            ],
            'when facing east' => [
                Coordinates::create(0, 0),
                CardinalPoint::south(),
                new MarsRover(Coordinates::create(0, 0), CardinalPoint::east())
            ],
            'when facing south' => [
                Coordinates::create(0, 0),
                CardinalPoint::west(),
                new MarsRover(Coordinates::create(0, 0), CardinalPoint::south())
            ],
            'when facing west' => [
                Coordinates::create(0, 0),
                CardinalPoint::north(),
                new MarsRover(Coordinates::create(0, 0), CardinalPoint::west())
            ],
        ])->it(
            'should turn clockwise',
            function ($expectedPosition, $expectedOrientation, MarsRover $rover) {
                $this->controlCenter->commands($rover, $this->planet, ['r']);

                expect($rover->position())->toEqual($expectedPosition);
                expect($rover->orientation())->toBe($expectedOrientation);
            }
        );
    });
});
