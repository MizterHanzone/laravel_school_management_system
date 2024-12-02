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
        Schema::create('time_tables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->unsignedBigInteger('day_id');
            $table->string('room_no')->nullable(); // Room number as a string
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->timestamps(); // Automatically adds 'created_at' and 'updated_at'

            // Foreign key constraints
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('day_id')->references('id')->on('days')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_tables');
    }
};
