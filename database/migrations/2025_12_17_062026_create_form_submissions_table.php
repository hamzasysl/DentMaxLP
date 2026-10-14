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
        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();

            // Form bilgisi
            $table->string('form_type', 20)->nullable();   // step | simple
            $table->string('source')->nullable();          // sayfa / lp
            $table->string('locale', 10)->nullable();      // tr | en | ar

            // Step form alanları
            $table->string('gender', 10)->nullable();      // men | women
            $table->string('tooth_model', 50)->nullable(); // aggressive, hollywood vs

            // Ortak alanlar
            $table->string('name', 120)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email', 180)->nullable();
            $table->text('message')->nullable();

            // Teknik bilgiler
            $table->string('ip', 45)->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_submissions');
    }
};
