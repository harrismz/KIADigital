<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyChildMonitoringAnswer extends Model
{
    use HasFactory;
    
    protected $table = "weekly_child_monitoring_answer";
    protected $guarded = ['id'];
}
