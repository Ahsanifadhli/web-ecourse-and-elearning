<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $guarded = ['id'];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    // --- WAJIB ADA INI AGAR TIDAK ERROR count() on null ---
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
