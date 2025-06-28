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
            if (Schema::hasColumn('proyeks', 'manajer_proyek_id')) {
                $table->dropForeign(['manajer_proyek_id']);
                $table->dropColumn('manajer_proyek_id');
            }
            if (Schema::hasColumn('proyeks', 'jenis_proyek_id')) {
                $table->dropForeign(['jenis_proyek_id']);
                $table->dropColumn('jenis_proyek_id');
            }
            $table->unsignedBigInteger('manajer_proyek_id')->after('nama_proyek');
            $table->unsignedBigInteger('jenis_proyek_id')->after('manajer_proyek_id');
            $table->foreign('manajer_proyek_id')->references('id')->on('manajer_proyeks')->onDelete('restrict');
            $table->foreign('jenis_proyek_id')->references('id')->on('jenis_proyeks')->onDelete('restrict');
            if (Schema::hasColumn('proyeks', 'manajer_proyek')) {
                $table->dropColumn('manajer_proyek');
            }
            if (Schema::hasColumn('proyeks', 'jenis_proyek')) {
                $table->dropColumn('jenis_proyek');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proyeks', function (Blueprint $table) {
            $table->string('manajer_proyek')->nullable();
            $table->string('jenis_proyek')->nullable();
            $table->dropForeign(['manajer_proyek_id']);
            $table->dropForeign(['jenis_proyek_id']);
            $table->dropColumn('manajer_proyek_id');
            $table->dropColumn('jenis_proyek_id');
        });
    }
};
