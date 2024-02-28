<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {//(number, departure_city, arrival_city,
//eparture_time, arrival_time)
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->integer('number')->unique();
            $table->string('departure_city');
            $table->string('arrival_city');
            $table->dateTime('departure_time');
            $table->dateTime('arrival_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
