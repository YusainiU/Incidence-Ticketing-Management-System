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

        

        Schema::create('service_level_agreements', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            /*
                name
                short_description
                sla_key
                start_day (Monday - Sunday)
                end_day (Monday - Sunday)
                service_start_time (in seconds)
                service_end_time (in seconds)
                include_public_holiday (boolean)
                cover_details (text)
            */
            $table->string('name');
            $table->string('short_description');
            $table->string('sla_key');
            $table->enum('start_day', ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'])->default('Monday');
            $table->enum('end_day', ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'])->default('Friday');
            $table->integer('service_start_time')->default(0);
            $table->integer('service_end_time')->default(0);
            $table->boolean('include_public_holiday')->default(false);
            $table->string('cover_details')->nullable();
            $table->boolean('active')->default(true);
            $table->enum('type', ['Support','Service'])->default('Service');
            $table->integer('response_time')->default(0);
            $table->integer('fixed_time')->default(0);            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_level_agreements');
    }
};
