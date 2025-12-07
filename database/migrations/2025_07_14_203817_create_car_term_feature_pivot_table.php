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
        Schema::create('car_term_feature', function (Blueprint $table) {
            $table->foreignId('car_term_id')->constrained('car_terms')->cascadeOnDelete();
            $table->foreignId('feature_id')->constrained('features')->cascadeOnDelete();
            $table->string('value')->nullable();
            $table->integer('priority')->default(0)->nullable(); // higher priority means higher in comparison table
            $table->boolean('status')->default(true)->nullable();
            $table->primary(['car_term_id', 'feature_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_term_feature');
    }
};
