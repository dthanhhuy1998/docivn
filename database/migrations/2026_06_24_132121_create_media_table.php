<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('related_type', 100)->nullable();
            $table->unsignedBigInteger('related_id')->nullable();

            $table->string('collection_name')->nullable()->index();
            $table->string('type', 30)->index();
            
            $table->string('disk', 50)->default('public');
            $table->string('directory')->nullable();
            $table->string('path');
            $table->string('file_name');
            $table->string('original_name');

            $table->string('mime_type', 150)->nullable();
            $table->string('extension', 20)->nullable()->index();
            $table->unsignedBigInteger('size')->default(0);

            $table->string('hash', 64)->nullable()->index();

            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();

            $table->unsignedInteger('duration')->nullable();

            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_primary')->default(false);

            $table->string('status', 30)->default('ready')->index();

            $table->json('metadata')->nullable();

            $table->unsignedBigInteger('created_by')->nullable()->index();

            $table->timestamps();

            $table->softDeletes();

            $table->unique(['disk', 'path']);

            $table->index([
                'related_type',
                'related_id',
                'collection_name',
            ], 'media_mediable_collection_index');

            $table->index([
                'type',
                'status',
            ], 'media_type_status_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
