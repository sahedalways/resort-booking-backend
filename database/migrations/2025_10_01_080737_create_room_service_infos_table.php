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
        Schema::create('room_service_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')
                ->nullable()
                ->constrained('rooms')
                ->onDelete('cascade');
            $table->foreignId('service_id')
                ->nullable()
                ->constrained('resort_service_types')
                ->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_service_infos');
    }
};
