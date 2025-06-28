<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jenis_proyeks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_jenis')->unique();
            $table->string('nama_jenis');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_proyeks');
    }
}; 