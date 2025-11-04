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
        Schema::create('access_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('username');
            $table->string('ipAddress');
            $table->integer('failedAttemptsCounter')->default(0);
            $table->dateTime('blockedDateTime')->nullable();
            $table->dateTime('unblockedDateTime')->nullable();
            $table->boolean('expired')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_logs');
    }
};
