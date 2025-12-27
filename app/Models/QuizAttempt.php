<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    // Tambahkan baris ini untuk mengizinkan input data
    protected $guarded = ['id'];

    // Atau bisa juga pakai: protected $fillable = ['quiz_id', 'user_id', 'score'];

    // Relasi (Opsional, tapi bagus untuk masa depan)
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
