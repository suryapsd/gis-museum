<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penguruses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('museum_id');
            $table->string('nama_pengurus', 60);
            $table->string('image')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('alamat_pengurus')->nullable();
            $table->string('telepon_pengurus')->nullable();
            $table->date('waktu_mulai')->nullable();
            $table->date('waktu_akhir')->nullable();
            $table->tinyInteger('is_aktif')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('penguruses');
    }
};
