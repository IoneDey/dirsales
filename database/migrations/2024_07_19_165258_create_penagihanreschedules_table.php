<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('penagihanreschedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('timsetupid');
            $table->string('nota');
            $table->date('tglreschedule');
            $table->integer('angsuranhari');
            $table->integer('angsuranperiode');
            $table->double('penjualan', 15, 8);
            $table->string('kurir', 150);
            $table->unsignedBigInteger('userid');
            $table->timestamps();
            $table->foreign('userid')->references('id')->on('users');
            $table->unique(['timsetupid', 'nota']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('penagihanreschedules');
    }
};
