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
        Schema::create('installment_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_id')->constrained('banks')->cascadeOnDelete();
            $table->string('name')->unique();
            $table->decimal('interest_rate_per_year', 5, 2)->default(0);
            $table->unsignedTinyInteger('applicable_to')->default(ApplicableToEnum::INDIVIDUAL);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installment_programs');
    }
};
