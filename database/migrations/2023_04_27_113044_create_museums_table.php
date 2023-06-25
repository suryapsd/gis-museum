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
        Schema::create('museums', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama', 60);
            $table->integer('jenis_id')->nullable();
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->text('desc')->nullable();
            $table->string('icon')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
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
        Schema::dropIfExists('museums');
    }
};
