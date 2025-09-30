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
        Schema::create('calons', function (Blueprint $table) {
            $table->id();
            $table->string('nama_calon');
            $table->string('foto')->nullable();
            $table->text('visi');
            $table->text('misi');
            $table->integer('jumlah_suara')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calons');
    }
};
