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
        Schema::table('car_models', function (Blueprint $table) {
            $table->string('maintenance_schedule_pdf')->nullable()->after('catalog'); // PDF path
            $table->string('view_360_degree')->nullable()->after('maintenance_schedule_pdf'); // 360° view link/path/iframe
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_models', function (Blueprint $table) {
            $table->dropColumn(['maintenance_schedule_pdf', 'view_360_degree']);
        });
    }
};
