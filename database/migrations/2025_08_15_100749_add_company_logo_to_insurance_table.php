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
        Schema::table('insurance', function (Blueprint $table) {
            $table->string('company_logo')->nullable()->after('insurance_company');
            $table->text('description')->nullable()->after('company_logo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insurance', function (Blueprint $table) {
            $table->dropColumn('company_logo');
            $table->dropColumn('description');
        });
    }
};
