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
        Schema::create('booking_car_clones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();
            $table->foreignId('car_brand_id');
            $table->string('car_brand_name');
            $table->foreignId('car_model_id');
            $table->string('car_model_name');
            $table->foreignId('car_term_id');
            $table->string('car_term_name');
            $table->foreignId('color_id')->nullable();
            $table->string('color_name')->nullable();
            $table->foreignId('second_color_id')->nullable();
            $table->string('second_color_name')->nullable();
            $table->decimal('price', 14, 0)->nullable();
            $table->decimal('reservation_amount', 14, 0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_car_clones');
    }
};
