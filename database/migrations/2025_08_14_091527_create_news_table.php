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
        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('writer_id');
            $table->text('title');
            $table->text('short_desc');
            $table->longText('details');
            $table->dateTime('added_date');
            $table->dateTime('scheduale_date');
            $table->text('related_tags');
            $table->text('home_img');
            $table->text('thumb_img');
            $table->unsignedBigInteger('number_of_reads');
            $table->integer('home');
            $table->text('altText');
            $table->integer('hidden');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
