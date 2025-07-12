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
        Schema::table('proyeks', function (Blueprint $table) {
            $table->integer('tahun')->after('lokasi_proyek')->nullable();
        });
        Schema::table('kriterias', function (Blueprint $table) {
            $table->integer('tahun')->nullable();
        });
        Schema::table('sub_kriterias', function (Blueprint $table) {
            $table->integer('tahun')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proyeks', function (Blueprint $table) {
            $table->dropColumn('tahun');
        });
        Schema::table('kriterias', function (Blueprint $table) {
            $table->dropColumn('tahun');
        });
        Schema::table('sub_kriterias', function (Blueprint $table) {
            $table->dropColumn('tahun');
        });
    }
}; 