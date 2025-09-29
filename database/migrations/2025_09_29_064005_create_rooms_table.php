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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resort_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->foreignId('bed_type_id')->nullable()->constrained('room_bed_types');
            $table->decimal('area', 8, 2)->nullable();
            $table->foreignId('view_type_id')->nullable()->constrained('room_view_types');
            $table->decimal('price', 10, 2);
            $table->unsignedTinyInteger('adult_cap')->default(1);
            $table->unsignedTinyInteger('child_cap')->default(0);
            $table->decimal('price_per', 10, 2)->nullable();
            $table->string('package_name')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
