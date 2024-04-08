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
        Schema::create('lock_downs', function (Blueprint $table) {
            $table->id()->unsignedTinyInteger();
            $table->timestamp('createdAt')->useCurrent();
            $table->timestamp('endedAt')->nullable();
            $table->enum('status', ['ACTIVE', 'ENDED'])->default('ACTIVE')->index();
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lock_downs');
    }
};
