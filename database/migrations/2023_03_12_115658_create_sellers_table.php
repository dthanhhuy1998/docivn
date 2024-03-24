<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->string('CapBac', 500)->nullable();
            $table->string('TenSeller', 500)->nullable();
            $table->string('Banner', 500)->nullable();
            $table->string('AnhDaiDien', 500)->nullable();
            $table->string('LinkFacebook', 500)->nullable();
            $table->string('SoDienThoai', 500)->nullable();
            $table->string('KhuVuc', 500)->nullable();
            $table->string('TrucThuoc', 500)->nullable();
            $table->datetime('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sellers');
    }
}
