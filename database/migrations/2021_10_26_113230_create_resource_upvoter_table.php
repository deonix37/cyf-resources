<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourceUpvoterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resource_upvoter', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resource_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('upvoter_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->unique(['resource_id', 'upvoter_id']);
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
        Schema::dropIfExists('resource_upvoter');
    }
}
