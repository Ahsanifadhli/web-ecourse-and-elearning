<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'title',
        'description',
        'time_limit',
        'passing_score',
    ];

    // Relasi ke Materi (Induk)
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    // Relasi ke Soal
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // --- INI YANG TADI HILANG (RELASI KE PERCOBAAN KUIS) ---
    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
}
