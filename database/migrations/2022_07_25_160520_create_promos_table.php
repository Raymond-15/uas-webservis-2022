<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('nama_promo', 36);
            $table->foreignId('kode_brg')->constrained('barangs')->cascadeOnDelete();
            $table->integer('diskon');
            $table->integer('qty_brg');
            $table->string('jadwal_id');
            $table->foreign('jadwal_id')->references('id')->on('jadwals')->cascadeOnDelete();
            // $table->foreignId('jadwal_id')->constrained('jadwals');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promos');
    }
}
