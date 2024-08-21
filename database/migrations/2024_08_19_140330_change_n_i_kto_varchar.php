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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik', 50)->change();
        });
        Schema::table('mother', function (Blueprint $table) {
            $table->string('nik', 50)->change();
            $table->string('no_jkn', 50)->change();
        });
        Schema::table('father', function (Blueprint $table) {
            $table->string('nik', 50)->change();
            $table->string('no_jkn', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('nik')->change();
        });
        Schema::table('mother', function (Blueprint $table) {
            $table->integer('nik')->change();
            $table->integer('no_jkn')->change();
        });
        Schema::table('father', function (Blueprint $table) {
            $table->integer('nik')->change();
            $table->integer('no_jkn')->change();
        });
    }
};
