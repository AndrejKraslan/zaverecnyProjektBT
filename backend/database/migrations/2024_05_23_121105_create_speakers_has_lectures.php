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
        Schema::create('speakers_has_lectures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('speaker_id')->notNull();
            $table->unsignedBigInteger('lecture_id')->notNull();
            $table->timestamps();

            $table->foreign('speaker_id')->references('speaker_id')->on('speakers')->onDelete('cascade');
            $table->foreign('lecture_id')->references('lecture_id')->on('lectures')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speakers_has_lectures');
    }
};
