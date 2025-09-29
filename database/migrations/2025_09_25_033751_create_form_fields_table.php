<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            $table->string('field_name');
            $table->enum('field_type', ['text', 'textarea', 'date', 'select']);
            $table->string('date_format')->nullable();
            $table->text('options')->nullable(); // kalau tipe select, simpan daftar pilihan
            $table->boolean('is_required')->default(false);
            $table->unsignedInteger('order')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_fields');
    }
};
