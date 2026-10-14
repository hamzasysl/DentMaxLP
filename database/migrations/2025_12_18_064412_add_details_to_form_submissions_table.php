<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('form_submissions', function (Blueprint $table) {
            // Kolonlar varsa güvenli şekilde sil
            if (Schema::hasColumn('form_submissions', 'gender')) {
                $table->dropColumn('gender');
            }

            if (Schema::hasColumn('form_submissions', 'tooth_model')) {
                $table->dropColumn('tooth_model');
            }
        });
    }

    public function down(): void
    {
        Schema::table('form_submissions', function (Blueprint $table) {
            // Geri alma (rollback için)
            $table->string('gender')->nullable()->after('geo_city');
            $table->string('tooth_model')->nullable()->after('gender');
        });
    }
};
