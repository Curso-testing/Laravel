<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('dinosaurs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('genus');
            $table->integer('length');
            $table->string('enclosure');
            // Si estás usando Enums en MySQL 8.0+ o una base de datos que soporte enums:
            $table->enum('health', ['HEALTHY', 'SICK'])->default('HEALTHY');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dinosaurs');
    }
};
