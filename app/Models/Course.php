<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Relasi ke Materi (Langsung ke Material, tanpa Section/Bab)
     * Digunakan di QuizController dan View
     */
    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    /**
     * Relasi ke Siswa (Student)
     * Digunakan di HomeController (Halaman Depan) untuk menghitung jumlah siswa
     * Asumsi tabel perantara bernama 'course_user' (standar Laravel)
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id')
                    ->withTimestamps();
    }

    /**
     * Relasi opsional jika nanti dibutuhkan (misal untuk mengambil Section jika Mas berubah pikiran)
     * Tapi untuk sekarang biarkan kosong atau komentar saja agar tidak error.
     */
    // public function sections()
    // {
    //     return $this->hasMany(Section::class);
    // }
}
