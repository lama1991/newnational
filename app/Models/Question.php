<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [

       'uuid' ,
        'content' ,
        'reference' ,
        'term_id',
        'college_id' ,
        'specialization_id'


    ];
    public function term()
    {
        return $this->belongsTo(Term::class);
    }
    public function college()
    {
        return $this->belongsTo(College::class);
    }
    public function specialization()
    {
        return $this->belongsTo( Specialization::class);
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

}
