<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kolon varsa drop et (MySQL/MariaDB fark etmez)
        if (Schema::hasColumn('form_submissions', 'gender')) {
            DB::statement('ALTER TABLE form_submissions DROP COLUMN gender');
        }

        if (Schema::hasColumn('form_submissions', 'tooth_model')) {
            DB::statement('ALTER TABLE form_submissions DROP COLUMN tooth_model');
        }
    }

    public function down(): void
    {
        // İstersen rollback için geri ekle
        if (!Schema::hasColumn('form_submissions', 'gender')) {
            DB::statement('ALTER TABLE form_submissions ADD COLUMN gender VARCHAR(255) NULL');
        }

        if (!Schema::hasColumn('form_submissions', 'tooth_model')) {
            DB::statement('ALTER TABLE form_submissions ADD COLUMN tooth_model VARCHAR(255) NULL');
        }
    }
};
