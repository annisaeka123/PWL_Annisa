<?php

//Mengimpor kelas-kelas Laravel yang digunakan dalam migrasi
use Illuminate\Database\Migrations\Migration; //Migration → Kelas dasar untuk migrasi database
use Illuminate\Database\Schema\Blueprint; //Blueprint → Digunakan untuk mendefinisikan struktur tabel
use Illuminate\Support\Facades\Schema; //Schema → Berisi metode untuk membuat, mengubah, atau menghapus tabel

//Class ini otomatis akan dieksekusi oleh Laravel saat menjalankan php artisan migrate
return new class extends Migration
{
    /**
     * untuk membuat tabel saat migrasi dijalankan
     */
    public function up(): void
    {
        //Membuat tabel stoks dengan bantuan Blueprint.
        //Jika tabel belum ada, Laravel akan membuatnya.
        Schema::create('stoks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->unsignetedInteger('jumlah_barang');
            $table->timestamps();
        });
    }

    /**
     * untuk menghapus tabel stoks jika migrasi dibatalkan
     */
    public function down(): void
    {
        //Menghapus tabel stoks jika ada.
        //Ini penting untuk memastikan rollback migrasi berjalan dengan benar
        Schema::dropIfExists('stoks');
    }
};
