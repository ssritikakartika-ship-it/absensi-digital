<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('qr_tokens', function (Blueprint $table) {
            // Hapus semua kolom sisa versi lama yang bikin error
            if (Schema::hasColumn('qr_tokens', 'waktu_mulai')) {
                $table->dropColumn('waktu_mulai');
            }
            if (Schema::hasColumn('qr_tokens', 'waktu_selesai')) {
                $table->dropColumn('waktu_selesai');
            }
            if (Schema::hasColumn('qr_tokens', 'waktu_berakhir')) {
                $table->dropColumn('waktu_berakhir');
            }

            // Pastikan kolom jam_mulai dan jam_selesai ada
            if (!Schema::hasColumn('qr_tokens', 'jam_mulai')) {
                $table->time('jam_mulai')->nullable();
            }
            if (!Schema::hasColumn('qr_tokens', 'jam_selesai')) {
                $table->time('jam_selesai')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('qr_tokens', function (Blueprint $table) {
            //
        });
    }
};