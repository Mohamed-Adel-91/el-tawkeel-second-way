<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('insurance_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insurance_id')->constrained('insurance')->cascadeOnDelete();
            $table->string('feature_name');
            $table->text('feature_value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_features');
    }
};
