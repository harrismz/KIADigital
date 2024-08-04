<?php

namespace App\Models;

use App\Http\Traits\ComboableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodType extends Model
{
    use HasFactory, ComboableTrait;
    protected $table = "blood_type";

    protected static $comboKey = 'blood_type_name';
}
