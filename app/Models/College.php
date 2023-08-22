<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;
    protected $fillable = [
       
       'uuid' , 'name' , 'logo' , 'category_id'
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function specializations()
    {
        return $this->hasMany(Specialization::class);
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function codes()
    {
        return $this->hasMany(Code::class);
    }
}
