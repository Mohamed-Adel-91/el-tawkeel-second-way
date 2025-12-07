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
        Schema::table('car_terms', function (Blueprint $table) {
            $table->json('color_over_price')
                ->nullable()
                ->after('reservation_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_terms', function (Blueprint $table) {
            $table->dropColumn('color_over_price');
        });
    }
};
