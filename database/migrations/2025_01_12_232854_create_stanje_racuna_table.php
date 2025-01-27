<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStanjeRacunaTable extends Migration
{
    public function up()
    {
        Schema::create('stanje_racuna', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Povezano s korisnikom
            $table->decimal('stanje', 10, 2)->default(0); // Novčano stanje
            $table->timestamps();

            // Dodavanje stranog ključa
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stanje_racuna');
    }
}
