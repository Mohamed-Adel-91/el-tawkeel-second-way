<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable()->index();
            $table->uuid('guest_token')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->unsignedBigInteger('car_id');
            $table->unsignedBigInteger('term_id')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->foreign('car_id')->references('id')->on('car_models')->restrictOnDelete();
            $table->foreign('term_id')->references('id')->on('car_terms')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropForeign(['car_id']);
            $table->dropForeign(['term_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('guests');
    }
};
