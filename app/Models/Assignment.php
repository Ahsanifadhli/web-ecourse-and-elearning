<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = ['material_id', 'title', 'description'];

    // Relasi ke Materi
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    // --- TAMBAHKAN INI (WAJIB) ---
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
