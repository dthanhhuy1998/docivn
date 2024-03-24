<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->id();
            $table->string('image', 255)->nullable();
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->text('summary')->nullable();
            $table->text('content')->nullable();
            $table->string('meta_title');
            $table->text('meta_description')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->integer('view')->default(0);
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('article');
    }
}
