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
        Schema::create('t_penjualan', function (Blueprint $table) {
            $table->id('penjualan_id');
            $table->unsignedBigInteger('user_id')->index(); //index untuk foreign key
            $table->string('pembeli', 20);
            $table->string('penjualan_kode', 20);
            $table->string('penjualan_tanggal');
            $table->timestamps();

            //mendefinisi foreign key pada kolom level_id mengacu pada kolom user_id di tabel
            $table->foreign('user_id')->references('user_id')->on('m_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_penjualan');
    }
};