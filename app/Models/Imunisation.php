<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imunisation extends Model
{
    use HasFactory;
    
    protected $table = "imunisation";

    protected $guarded = ['id'];
}
