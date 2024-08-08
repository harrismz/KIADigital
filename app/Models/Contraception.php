<?php

namespace App\Models;

use App\Http\Traits\ComboableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contraception extends Model
{
    use HasFactory, ComboableTrait;
    
    protected $table = "contraception";
    
    protected static $comboKey = 'contraception_name';

}
