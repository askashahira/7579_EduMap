<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Siapa yang melapor
            $table->string('school_name');
            $table->string('province');
            $table->string('regency'); // Kabupaten/Kota
            $table->integer('teacher_count');
            $table->integer('student_count');
            $table->string('internet_access'); // 'stabil', 'terbatas', 'tidak_tersedia'
            $table->date('report_date');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('status')->default('pending'); // 'pending', 'approved', 'rejected'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_reports');
    }
};
