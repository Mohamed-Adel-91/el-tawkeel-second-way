<?php

use App\Enums\ApplicableToEnum;
use App\Enums\CashMethodEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\PaymentTypeEnum;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // link to who bought & what they bought
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->foreignId('car_term_id')->constrained('car_terms')->restrictOnDelete();
            $table->unsignedInteger('first_color_id');
            $table->unsignedInteger('second_color_id')->nullable();
            $table->unsignedInteger('insurance_programe_id')->nullable();
            $table->string('insurance_programe_name')->nullable();
            $table->string('branch_name')->nullable();

            // payment setup
            $table->unsignedTinyInteger('payment_type')->default(PaymentTypeEnum::CASH);
            $table->unsignedTinyInteger('customer_type')->default(ApplicableToEnum::INDIVIDUAL);

            // cash_method → tiny integer nullable, default visa
            $table->unsignedTinyInteger('cash_method')->nullable()->default(CashMethodEnum::VISA);
            $table->string('account_number')->nullable();
            $table->string('cash_full_name')->nullable();
            $table->string('cash_phone_number')->nullable();
            $table->string('cash_individual_email')->nullable();
            $table->string('cash_national_id')->nullable();
            $table->string('cash_front_national_id_image')->nullable();
            $table->string('cash_back_national_id_image')->nullable();

            // installment options
            $table->unsignedInteger('bank_id')->nullable();
            $table->string('bank_name')->nullable();
            $table->unsignedInteger('installment_program_id')->nullable();
            $table->string('installment_program_name')->nullable();
            $table->unsignedTinyInteger('installment_duration')->nullable();

            // pricing
            $table->decimal('price', 14, 0);

            // pricing in both cash & installment case
            $table->decimal('reservation_amount', 14, 0);

            // pricing in installment case
            $table->decimal('interest_rate', 5, 2)->nullable();
            $table->decimal('down_payment_percent', 5, 2)->nullable();
            $table->decimal('down_payment_amount', 12, 0)->nullable();
            $table->decimal('monthly_installment_amount', 15, 0)->nullable();

            // KYC / uploads
            // - Individuals
            $table->string('installment_full_name')->nullable();
            $table->string('installment_phone_number')->nullable();
            $table->string('installment_individual_email')->nullable();
            $table->string('installment_national_id')->nullable();
            $table->string('installment_front_national_id_image')->nullable();
            $table->string('installment_back_national_id_image')->nullable();
            $table->string('installment_bank_statement')->nullable();
            $table->string('installment_hr_letter')->nullable();

            // - Companies
            $table->string('installment_company_name')->nullable();
            $table->string('installment_legal_representative_phone_number')->nullable();
            $table->string('installment_company_email')->nullable();
            $table->string('installment_commercial_registration_number')->nullable();
            $table->string('installment_commercial_registration_image')->nullable();
            $table->string('installment_tax_card_number')->nullable();
            $table->string('installment_tax_card_image')->nullable();
            $table->string('installment_company_bank_statement')->nullable();

            // agreement
            $table->boolean('agreed_terms')->default(false);
            $table->string('reference_number')->unique()->nullable();

            // status
            $table->unsignedTinyInteger('status')->default(OrderStatusEnum::PENDING);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
