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
            $table->string('torque')->nullable()->after('horse_power');
            $table->string('gear_box')->nullable()->after('torque');
            $table->string('banner_tablet')->nullable()->after('image');
            $table->string('banner_mobile')->nullable()->after('banner_tablet');
            $table->boolean('is_home')->default(false)->after('show_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_models', function (Blueprint $table) {
            $table->dropColumn([
                'torque',
                'gear_box',
                'banner_tablet',
                'banner_mobile',
                'is_home',
            ]);
        });
    }
};
