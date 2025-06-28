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
        Schema::table('ranking_batches', function (Blueprint $table) {
            $table->longText('calculation_details')->nullable()->after('catatan');
            $table->json('assessment_details')->nullable()->after('calculation_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ranking_batches', function (Blueprint $table) {
            $table->dropColumn('calculation_details');
            $table->dropColumn('assessment_details');
        });
    }
};
