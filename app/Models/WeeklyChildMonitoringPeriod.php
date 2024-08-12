<?php

namespace App\Models;

use App\Http\Traits\ComboableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyChildMonitoringPeriod extends Model
{
    use HasFactory, ComboableTrait;
    protected $table = "weekly_child_monitoring_period";

    protected static $comboKey = 'period_name';
}
