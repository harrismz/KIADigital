<?php

namespace App\Models;

use App\Http\Traits\ComboableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory, ComboableTrait;

    protected $table = "education";

    protected static $comboKey = 'education_name';

    public function mother():hasMany
    {
        return $this->hasMany(Mother::class);
    }
}
