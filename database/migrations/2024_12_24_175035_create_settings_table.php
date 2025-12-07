<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('slogan')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('hotline')->nullable();
            $table->string('location')->nullable();
            $table->string('facebook')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();
            $table->string('instagram')->nullable();
            $table->string('email')->nullable();
            $table->string('hr_mail')->nullable();
            $table->string('customer_service_mail')->nullable();
            $table->timestamps();
        });

        DB::table('settings')->insert([
            'slogan' => 'test',
            'address' => '28 شارع 7 - المعادي القاهرة - مصر',
            'phone' => '1234567890',
            'hotline' => '1234567890',
            'location' => 'test',
            'facebook' => 'https://www.facebook.com/eltawkeel/',
            'linkedin' => 'https://www.linkedin.com/company/eltawkeel/',
            'youtube' => 'https://www.youtube.com/@eltawkeel?app=desktop',
            'instagram' => 'https://www.instagram.com/eltawkeel/',
            'email' => 'info@eltawkeel.com',
            'hr_mail' => 'hr@eltawkeel.com',
            'customer_service_mail' => 'customer.service@eltawkeel.com',
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
