<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Dinosaur;
use App\Enums\HealthStatus;

class DinosaurTest extends TestCase
{

    public function testCanGetAndSetData(): void
    {
        $dino = new Dinosaur();
        $dino->name = 'Big Eaty';
        $dino->genus = 'Tyrannosaurus';
        $dino->length = 15;
        $dino->enclosure = 'Paddock A';

        $this->assertSame('Big Eaty', $dino->name);
        $this->assertSame('Tyrannosaurus', $dino->genus);
        $this->assertSame(15, $dino->length);
        $this->assertSame('Paddock A', $dino->enclosure);
    }

    /**
     * @dataProvider sizeDescriptionProvider
     */
    public function testDinoHasCorrectSizeDescriptionFromLength(int $length, string $expectedSize): void
    {
        $dino = new Dinosaur();
        $dino->length = $length;

        // Asumiendo que implementaste getSizeDescription como un accesor en el modelo Dinosaur de Laravel
        $this->assertSame($expectedSize, $dino->sizeDescription());
    }

    public function sizeDescriptionProvider(): \Generator
    {
        yield '10 Meter Large Dino' => [10, 'Large'];
        yield '5 Meter Medium Dino' => [5, 'Medium'];
        yield '4 Meter Small Dino' => [4, 'Small'];
    }

    public function testIsAcceptingVisitorsByDefault(): void
    {
        $dino = new Dinosaur(['name' => 'Dennis', 'genus' => 'Dilophosaurus', 'length' => 6, 'enclosure' => 'Paddock B']);
        $dino->health = HealthStatus::HEALTHY;
        $this->assertTrue($dino->isAcceptingVisitors());
    }

    /**
     * @dataProvider healthStatusProvider
     */
    public function testIsAcceptingVisitorsBasedOnHealthStatus(HealthStatus $healthStatus, bool $expectedVisitorStatus): void
    {
        $dino = new Dinosaur(['name' => 'Dennis', 'genus' => 'Dilophosaurus', 'length' => 6, 'enclosure' => 'Paddock B']);
        $dino->health = $healthStatus;

        $this->assertSame($expectedVisitorStatus, $dino->isAcceptingVisitors());
    }

    public function healthStatusProvider(): \Generator
    {
        yield 'Sick dino is not accepting visitors' => [HealthStatus::SICK, false];
        // Asegúrate de que HealthStatus incluya 'HUNGRY' si es parte de tu implementación
        yield 'Hungry dino is accepting visitors' => [HealthStatus::HUNGRY, true];
    }
}
