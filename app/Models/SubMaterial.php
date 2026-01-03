<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMaterial extends Model
{
    use HasFactory;

    protected $fillable = ['material_id', 'title', 'type', 'link', 'file_path', 'description'];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    // --- TAMBAHKAN INI (WAJIB) ---
    // Relasi ke tabel completions untuk melihat siapa saja yang sudah menyelesaikan materi ini
    public function completions()
    {
        return $this->hasMany(Completion::class);
    }
}
