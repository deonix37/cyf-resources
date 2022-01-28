<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEngineReleasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('engine_releases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('engine_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('version');
            $table->timestamps();
            $table->unique(['engine_id', 'version']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('engine_releases');
    }
}
