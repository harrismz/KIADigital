<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyMonitoringAnswer extends Model
{
    use HasFactory;
    protected $table = "weekly_monitoring_answer";
    protected $guarded = ['id'];
}
