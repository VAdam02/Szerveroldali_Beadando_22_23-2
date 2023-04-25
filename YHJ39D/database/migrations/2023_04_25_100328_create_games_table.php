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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start', $precision = 0);
            $table->boolean('finished')->default(false);
            
            $table->string('homeTeamLogo')->nullable();
            $table->string('homeTeamName');
            $table->string('homeTeamShortName');
            $table->integer('homeTeamScore')->nullable();

            $table->string('awayTeamLogo')->nullable();
            $table->string('awayTeamName');
            $table->string('awayTeamShortName');
            $table->integer('awayTeamScore')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
