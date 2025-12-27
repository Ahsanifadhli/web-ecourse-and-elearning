<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = ['id'];

    public function quiz() { return $this->belongsTo(Quiz::class); }
    public function options() { return $this->hasMany(Option::class); }
}
