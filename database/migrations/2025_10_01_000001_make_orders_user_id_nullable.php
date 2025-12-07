<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        DB::statement('ALTER TABLE orders MODIFY user_id BIGINT UNSIGNED NULL');

        Schema::table('orders', function (Blueprint $table) {
            $table->string('session_id')->nullable()->index()->after('user_id');
            $table->uuid('guest_token')->nullable()->index()->after('session_id');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['session_id', 'guest_token']);
        });

        DB::table('orders')->whereNull('user_id')->delete();
        DB::statement('ALTER TABLE orders MODIFY user_id BIGINT UNSIGNED NOT NULL');

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->restrictOnDelete();
        });
    }
};
