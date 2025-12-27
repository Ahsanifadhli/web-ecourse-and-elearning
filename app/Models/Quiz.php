<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $guarded = ['id'];

    public function material() { return $this->belongsTo(Material::class); }
    public function questions() { return $this->hasMany(Question::class); }
}
