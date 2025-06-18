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
        Schema::create('ranking_batches', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sesi');
            $table->timestamp('calculated_at');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('catatan')->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ranking_batches');
    }
};
