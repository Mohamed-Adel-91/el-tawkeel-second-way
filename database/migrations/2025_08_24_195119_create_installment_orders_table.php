<?php

use App\Enums\ServicesOrderStatusEnum;
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
        Schema::create('installment_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('dealing_type');

            $table->foreignId('branch_id')->nullable()->constrained('service_centers')->nullOnDelete()->cascadeOnUpdate();
            $table->string('branch_name')->nullable();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete()->cascadeOnUpdate();
            $table->string('brand_name')->nullable();
            $table->foreignId('car_model_id')->nullable()->constrained('car_models')->nullOnDelete()->cascadeOnUpdate();
            $table->string('car_model_name')->nullable();
            $table->foreignId('term_id')->nullable()->constrained('car_terms')->nullOnDelete()->cascadeOnUpdate();
            $table->string('term_name')->nullable();
            $table->foreignId('program_id')->nullable()->constrained('installment_programs')->nullOnDelete()->cascadeOnUpdate();
            $table->string('program_name')->nullable();
            $table->string('bank_name')->nullable();
            $table->decimal('program_interest_rate_per_year', 6, 2)->nullable();

            $table->unsignedInteger('tenor_months')->nullable();
            $table->decimal('car_price', 14, 2)->nullable();
            $table->decimal('down_payment', 14, 2)->nullable();
            $table->decimal('down_payment_percent', 5, 2)->nullable();
            $table->decimal('monthly_payment_at_submission', 14, 2)->nullable();
            $table->decimal('total_payable_at_submission', 14, 2)->nullable();

            $table->string('full_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('national_id')->nullable();
            $table->string('front_national_id_image')->nullable();
            $table->string('back_national_id_image')->nullable();
            $table->string('bank_statement')->nullable();
            $table->string('hr_letter')->nullable();

            $table->string('company_name')->nullable();
            $table->string('representative_phone')->nullable();
            $table->string('company_email')->nullable();
            $table->string('commercial_registration_number')->nullable();
            $table->string('commercial_registration_image')->nullable();
            $table->string('tax_card_image')->nullable();
            $table->string('company_bank_statement')->nullable();

            $table->unsignedTinyInteger('car_owned_by_other')->nullable();
            $table->boolean('agreed_terms')->default(false);
            $table->unsignedTinyInteger('status')->default(ServicesOrderStatusEnum::PENDING);
            $table->string('reference_number')->nullable()->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installment_orders');
    }
};
