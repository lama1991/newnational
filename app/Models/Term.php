<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;
    protected $fillable = [
        
       'uuid' , 'name' , 'specializtion_id'
    ];
    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

}
