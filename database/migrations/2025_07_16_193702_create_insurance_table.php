<?php

use App\Enums\ApplicableToEnum;
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
        Schema::create('insurance', function (Blueprint $table) {
            $table->id();
            $table->string('insurance_company');
            $table->string('program_name');
            $table->decimal('coverage_rate', 5, 2)->default(100);
            $table->decimal('annual_price', 10, 0)->default(0);
            $table->decimal('monthly_payment', 10, 0)->default(0);
            $table->unsignedTinyInteger('applicable_to')->default(ApplicableToEnum::INDIVIDUAL);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance');
    }
};
