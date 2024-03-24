<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_logs', function (Blueprint $table) {
            $table->id();
            $table->string('AnhDaiDien', 500)->nullable();
            $table->string('TenSeller', 500)->nullable();
            $table->string('CapBacCu', 500)->nullable();
            $table->string('CapBacMoi', 500)->nullable();
            $table->datetime('NgayThangCap')->nullable();
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
        Schema::dropIfExists('seller_logs');
    }
}
