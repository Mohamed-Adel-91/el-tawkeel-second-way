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
        Schema::create('car_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete();
            $table->foreignId('shape_id')->constrained('shapes')->cascadeOnDelete();
            $table->string('name')->unique();
            $table->string('image')->nullable(); // main image
            $table->decimal('start_price', 14, 0)->nullable();
            $table->string('catalog')->nullable();
            $table->unsignedSmallInteger('year')->nullable();
            $table->string('engine')->nullable();
            $table->string('engine_type')->nullable();
            $table->unsignedInteger('horse_power')->nullable();
            $table->boolean('show_status')->default(true)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_models');
    }
};
