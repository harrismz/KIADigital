<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pregnancy', function (Blueprint $table) {
            //
            $table->date('first_day_of_last_period')->change();
            $table->date('estimate_date_of_delivery')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pregnancy', function (Blueprint $table) {
            //
            $table->dateTime('first_day_of_last_period')->change();
            $table->dateTime('estimate_date_of_delivery')->change();
        });
    }
};
