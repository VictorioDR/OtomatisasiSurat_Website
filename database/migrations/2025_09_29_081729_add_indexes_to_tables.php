<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->index('user_id'); // Index untuk pencarian template per user
        });

        Schema::table('form_fields', function (Blueprint $table) {
            $table->index('template_id'); // Index untuk pencarian field per template
        });

        Schema::table('generated_documents', function (Blueprint $table) {
            $table->index('user_id'); // Index untuk pencarian riwayat per user
            $table->index('template_id'); // Index untuk relasi ke template
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
};
