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
        Schema::create('booking_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resort_id')->nullable()->constrained('resorts')->onDelete('set null');
            $table->foreignId('room_id')->nullable()->constrained('rooms')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->decimal('amount', 10, 2)->nullable();


            $table->enum('booking_for', ['me', 'others'])->default('me');
            $table->text('additional_comment')->nullable();
            $table->boolean('is_used_coupon')->default(false);
            $table->integer('adult')->default(1);
            $table->integer('child')->default(0);

            $table->date('start_date');
            $table->date('end_date');
            $table->string('invoice')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_infos');
    }
};
