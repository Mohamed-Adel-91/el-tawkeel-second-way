<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'provider_order_reference')) {
                $table->string('provider_order_reference')->nullable();
            }

            if (!Schema::hasColumn('orders', 'provider_transaction_reference')) {
                $table->string('provider_transaction_reference')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'provider_order_reference')) {
                $table->dropColumn('provider_order_reference');
            }

            if (Schema::hasColumn('orders', 'provider_transaction_reference')) {
                $table->dropColumn('provider_transaction_reference');
            }
        });
    }
};
