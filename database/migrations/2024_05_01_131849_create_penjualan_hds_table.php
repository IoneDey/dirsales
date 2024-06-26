<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('penjualanhds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('timsetupid');
            $table->string('nota')->unique();
            $table->string('kecamatan', 150);
            $table->date('tgljual');
            $table->integer('angsuranhari');
            $table->integer('angsuranperiode');
            $table->string('customernama', 150);
            $table->string('customeralamat', 255);
            $table->string('customernotelp');
            $table->string('shareloc', 150);
            $table->string('namasales', 150);
            $table->string('namalock', 150);
            $table->string('namadriver', 150);
            $table->string('pjkolektornota', 150);
            $table->string('pjadminnota', 150);
            $table->string('fotoktp')->nullable();
            $table->string('fotonota')->nullable();
            $table->string('fotonotarekap')->nullable();
            $table->string('status', 11);
            $table->unsignedBigInteger('userid');
            $table->timestamps();
            $table->unsignedBigInteger('userlockid')->nullable();
            $table->timestamp('validatedlock_at')->nullable();
            $table->unsignedBigInteger('useradmin1id')->nullable();
            $table->timestamp('validatedadmin1_at')->nullable();
            $table->boolean('sheet')->default(false);
            $table->foreign('timsetupid')->references('id')->on('timsetups');
            $table->foreign('userid')->references('id')->on('users');
            $table->foreign('userlockid')->references('id')->on('users');
            $table->foreign('useradmin1id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('penjualan_hds');
    }
};
