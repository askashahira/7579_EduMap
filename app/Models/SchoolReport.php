<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolReport extends Model
{
    use HasFactory;

    // Tambahkan ini
    protected $fillable = [
        'user_id',
        'school_name',
        'province',
        'regency',
        'teacher_count',
        'student_count',
        'internet_access',
        'report_date',
        'latitude',
        'longitude',
        'status',
    ];
}