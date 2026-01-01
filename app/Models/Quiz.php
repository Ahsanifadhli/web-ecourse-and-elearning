<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['material_id', 'title', 'description', 'passing_score']; // Pastikan passing_score ada

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // --- TAMBAHKAN INI (WAJIB) ---
    // Relasi untuk melihat siapa saja yang sudah mengerjakan kuis ini
    public function attempts() // Bisa juga dinamakan 'results'
    {
        return $this->hasMany(QuizAttempt::class);
    }
}
