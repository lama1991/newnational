<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasFactory;
    protected $fillable = [

       'uuid' , 'code' , 'user_id' , 'college_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function college()
    {
        return $this->belongsTo(College::class);
    }
}
