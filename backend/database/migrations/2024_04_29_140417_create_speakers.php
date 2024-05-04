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
        Schema::create('speakers', function (Blueprint $table) {
            $table->id('speaker_id')->primary();
            $table->string('name',150);
            $table->string('description_short',150);
            $table->text('description_long');
            $table->string('image',500);
            $table->string('facebook_url',500);
            $table->string('instagram_url',500);
            $table->string('twitter_url',500);
            $table->string('web_url',500);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speakers');
    }
};
