<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ComboableTrait;
class Kecamatan extends Model
{
    use HasFactory, ComboableTrait;
    
    protected $table = "kecamatan";

    protected static $comboKey = 'kecamatan_name';


}
