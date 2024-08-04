<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildDevelopmentHistory extends Model
{
    use HasFactory;
    protected $table = "child_development_history";

    protected $guarded = ['id'];
}
