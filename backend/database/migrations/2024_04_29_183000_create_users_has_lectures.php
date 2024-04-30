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
    {
        Schema::create('users_has_lectures', function (Blueprint $table) {
            // toto neviem ci je spravne!!!!
            //
            //
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('lecture_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('lecture_id')->references('lecture_id')->on('lectures');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_has_lectures');
    }
};
