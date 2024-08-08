<?php

namespace App\Models;

use App\Http\Traits\ComboableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
    use HasFactory, ComboableTrait;
    
    protected $table = "religion";

    protected static $comboKey = 'religion_name';

}

