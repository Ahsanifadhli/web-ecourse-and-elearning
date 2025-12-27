<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $guarded = ['id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Satu Materi (Bab) punya banyak Sub-Materi (Isi)
    public function subMaterials()
    {
        return $this->hasMany(SubMaterial::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    // Nanti Kuis & Tugas juga relasinya ke sini
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
