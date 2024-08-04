<?php

namespace App\Models;

use App\Http\Traits\ComboableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory, ComboableTrait;
    
    protected $table = "job";

    protected static $comboKey = 'job_name';
}
