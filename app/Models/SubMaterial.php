<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubMaterial extends Model
{
    protected $guarded = ['id'];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
