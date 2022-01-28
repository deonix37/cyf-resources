<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resource_type_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('engine_release_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('uploader_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->string('title')->index();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('youtube_video_id')->nullable();
            $table->boolean('is_draft')->default(true);
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
        Schema::dropIfExists('resources');
    }
}
