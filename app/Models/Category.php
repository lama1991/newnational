<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        
       'uuid' , 'name' , 'logo'
    ];
    public function colleges()
    {
        return $this->hasMany(College::class);
    }

}
