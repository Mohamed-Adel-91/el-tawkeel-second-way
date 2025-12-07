<?php

use App\Enums\OrderStatusEnum;
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
        Schema::create('insurance_orders', function (Blueprint $table) {
            $table->id();
            // link to who bought & what they bought
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->string('brand_name')->nullable();

            $table->foreignId('car_model_id')->nullable()->constrained('car_models')->nullOnDelete();
            $table->string('car_model_name')->nullable();

            $table->foreignId('car_term_id')->nullable()->constrained('car_terms')->nullOnDelete();
            $table->string('car_term_name')->nullable();

            $table->foreignId('insurance_id')->nullable()->constrained('insurance')->nullOnDelete();
            $table->string('insurance_program_name')->nullable();
            $table->string('insurance_company_name')->nullable();

            // pricing
            $table->decimal('car_price', 15, 0);
            $table->unsignedBigInteger('annual_price_at_submission')->nullable();


            // KYC / uploads
            // - Individuals
            $table->string('full_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('individual_email')->nullable();
            $table->string('national_id')->nullable();
            $table->string('front_national_id_image')->nullable();
            $table->string('back_national_id_image')->nullable();

            // - Companies
            $table->string('company_name')->nullable();
            $table->string('legal_representative_phone_number')->nullable();
            $table->string('company_email')->nullable();
            $table->string('commercial_registration_number')->nullable();
            $table->string('commercial_registration_image')->nullable();
            $table->string('tax_card_number')->nullable();
            $table->string('tax_card_image')->nullable();

            // agreement
            $table->boolean('agreed_terms')->default(false);
            $table->boolean('other_ownership')->default(false);
            $table->boolean('sale_blocked')->default(false);
            $table->string('chassis_number')->nullable();
            $table->string('car_license_image')->nullable();
            $table->string('car_documentation_image')->nullable();

            // status
            $table->unsignedTinyInteger('status')->default(OrderStatusEnum::PENDING);
            $table->string('reference_number')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_orders');
    }
};
