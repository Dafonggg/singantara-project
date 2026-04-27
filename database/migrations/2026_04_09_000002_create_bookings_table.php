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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('paket_id')->constrained()->onDelete('cascade');
            $table->string('kode_booking')->unique();
            $table->date('tanggal_acara');
            $table->time('jam_acara');
            $table->string('nama_acara');
            $table->text('alamat');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status', [
                'pending',
                'confirmed',
                'dp_paid',
                'paid',
                'ongoing',
                'completed',
                'cancelled'
            ])->default('pending');
            $table->decimal('total_harga', 12, 2);
            $table->decimal('biaya_transport', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
