<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    use HasFactory;
    protected $fillable = [
       
       'uuid' , 'name' , 'college_id'
    ];
    public function college()
    {
        return $this->belongsTo(College::class);
    }
    public function terms()
    {
        return $this->hasMany(Term::class);
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
  
}
