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
        Schema::create('resort_facility_option_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resort_id')->constrained('resorts')->onDelete('cascade');
            $table->foreignId('facility_id')->constrained('resort_room_facilities')->onDelete('cascade');

            $table->string('type_name');
            $table->string('icon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resort_facility_option_services');
    }
};
