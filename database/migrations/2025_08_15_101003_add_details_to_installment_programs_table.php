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
        Schema::table('installment_programs', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
            $table->string('card_image')->nullable()->after('description');
            $table->json('features')->nullable()->after('applicable_to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('installment_programs', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('card_image');
            $table->dropColumn('features');
        });
    }
};
