<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dinosaur;
use App\Models\LockDown;
use App\Enums\LockDownStatus;

class AppSeeder extends Seeder
{
    public function run()
    {
        $dino1 = Dinosaur::create(['name' => 'Daisy', 'genus' => 'Velociraptor', 'length' => 2, 'enclosure' => 'Paddock A']);
        $dino2 = Dinosaur::create(['name' => 'Maverick', 'genus' => 'Pterodactyl', 'length' => 7, 'enclosure' => 'Aviary 1']);
        $dino3 = Dinosaur::create(['name' => 'Big Eaty', 'genus' => 'Tyrannosaurus', 'length' => 15, 'enclosure' => 'Paddock C']);
        $dino4 = Dinosaur::create(['name' => 'Dennis', 'genus' => 'Dilophosaurus', 'length' => 6, 'enclosure' => 'Paddock B']);
        $dino5 = Dinosaur::create(['name' => 'Bumpy', 'genus' => 'Triceratops', 'length' => 10, 'enclosure' => 'Paddock B']);

        $lockDown = new LockDown();
        $lockDown->status = LockDownStatus::ACTIVE;
        $lockDown->reason = 'We have a T-Rex... and he\'s like, not in his cage!';
        $lockDown->save();
    }
}
