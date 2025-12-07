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
        Schema::table('car_term_feature', function (Blueprint $table) {
            if (Schema::hasColumn('car_term_feature', 'priority')) {
                $table->dropColumn('priority');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_term_feature', function (Blueprint $table) {
            if (!Schema::hasColumn('car_term_feature', 'priority')) {
                $table->integer('priority')->default(0)->nullable();
            }
        });
    }
};
