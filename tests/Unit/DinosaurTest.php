<?php

use App\Models\Dinosaur;
use App\Enums\HealthStatus;


test('can get and set data', function () {
    $dino = new Dinosaur();
    $dino->name = 'Big Eaty';
    $dino->genus = 'Tyrannosaurus';
    $dino->length = 15;
    $dino->enclosure = 'Paddock A';

    expect($dino->name)->toBe('Big Eaty');
    expect($dino->genus)->toBe('Tyrannosaurus');
    expect($dino->length)->toBe(15);
    expect($dino->enclosure)->toBe('Paddock A');
});

test('dino has correct size description from length', function (int $length, string $expectedSize) {
    $dino = new Dinosaur();
    $dino->length = $length;

    // Asumiendo que implementaste getSizeDescription como un accesor en el modelo Dinosaur de Laravel
    expect($dino->sizeDescription())->toBe($expectedSize);
})->with('sizeDescriptionProvider');

dataset('sizeDescriptionProvider', function () {
    yield '10 Meter Large Dino' => [10, 'Large'];
    yield '5 Meter Medium Dino' => [5, 'Medium'];
    yield '4 Meter Small Dino' => [4, 'Small'];
});

test('is accepting visitors by default', function () {
    $dino = new Dinosaur(['name' => 'Dennis', 'genus' => 'Dilophosaurus', 'length' => 6, 'enclosure' => 'Paddock B']);
    $dino->health = HealthStatus::HEALTHY;
    expect($dino->isAcceptingVisitors())->toBeTrue();
});

test('is accepting visitors based on health status', function (HealthStatus $healthStatus, bool $expectedVisitorStatus) {
    $dino = new Dinosaur(['name' => 'Dennis', 'genus' => 'Dilophosaurus', 'length' => 6, 'enclosure' => 'Paddock B']);
    $dino->health = $healthStatus;

    expect($dino->isAcceptingVisitors())->toBe($expectedVisitorStatus);
})->with('healthStatusProvider');

dataset('healthStatusProvider', function () {
    yield 'Sick dino is not accepting visitors' => [HealthStatus::SICK, false];

    // Asegúrate de que HealthStatus incluya 'HUNGRY' si es parte de tu implementación
    yield 'Hungry dino is accepting visitors' => [HealthStatus::HUNGRY, true];
});
