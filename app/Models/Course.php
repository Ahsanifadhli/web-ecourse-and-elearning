<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // Tambahkan baris ini (Artinya: Tidak ada kolom yang dijaga/dilarang diisi)
    protected $guarded = [];

    // Relasi ke Materi (Nanti kita butuh ini)
    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    // Relasi ke Tugas
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_user')
                    ->withTimestamps(); // Agar created_at terbawa
    }
}
