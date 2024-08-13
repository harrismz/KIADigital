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
        Schema::table('weekly_monitoring_answer', function (Blueprint $table) {
            //
            $table->text('question')->nullable();
            $table->text('answer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weekly_monitoring_answer', function (Blueprint $table) {
            //
            $table->dropColumn('question');
            $table->dropColumn('answer');
        });
    }
};
