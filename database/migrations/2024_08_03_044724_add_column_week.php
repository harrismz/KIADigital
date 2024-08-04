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
        Schema::table('pregnancy_history', function (Blueprint $table) {
            $table->string('week')->nullable()->comment('Week of pregnancy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pregnancy_history', function (Blueprint $table) {
            $table->dropColumn('week');
        });
    }
};
