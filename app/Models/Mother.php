<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mother extends Model
{
    use HasFactory;
    
    protected $table = "mother";

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
