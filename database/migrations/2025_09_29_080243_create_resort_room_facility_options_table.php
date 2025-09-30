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
        Schema::create('resort_room_facility_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('facility_id')
                ->constrained('resort_room_facilities')
                ->onDelete('cascade');
            $table->foreignId('service_id')
                ->constrained('resort_service_types')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resort_room_facility_options');
    }
};
