<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('form_submissions', function (Blueprint $table) {
            $table->string('geo_country', 2)->nullable(); // RU, TR, DE
            $table->string('geo_region')->nullable();     // Moscow, Istanbul
            $table->string('geo_city')->nullable();       // Moscow, Berlin
        });
    }

    public function down(): void
    {
        Schema::table('form_submissions', function (Blueprint $table) {
            $table->dropColumn(['geo_country','geo_region','geo_city']);
        });
    }
};
