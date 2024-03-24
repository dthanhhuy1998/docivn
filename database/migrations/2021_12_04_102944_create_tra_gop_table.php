<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTraGopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tra_gop', function (Blueprint $table) {
            $table->id();
            $table->string('p_name', 255)->nullable();
            $table->string('p_image', 255)->nullable();
            $table->string('customer_name', 255);
            $table->string('customer_card_id', 50)->nullable();
            $table->string('customer_phone', 50);
            $table->string('customer_email', 255)->nullable();
            $table->foreignId('province_id');
            $table->string('percent', 10)->nullable();
            $table->string('month', 10)->nullable();
            $table->string('note', 255)->nullable();
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('tra_gop');
    }
}
