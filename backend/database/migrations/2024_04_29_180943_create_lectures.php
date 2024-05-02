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
        Schema::create('lectures', function (Blueprint $table) {
            $table->id('lecture_id');
            $table->string('name');
            $table->text('description');
            $table->string('image', 500);
            $table->integer('capacity');
            $table->integer('max_capacity');
            $table->time('start');
            $table->time('end');
            $table->unsignedBigInteger('speaker_id');
            $table->unsignedBigInteger('stage_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('speaker_id')->references('speaker_id')->on('speakers');
            $table->foreign('stage_id')->references('stage_id')->on('stages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lectures');
    }
};
