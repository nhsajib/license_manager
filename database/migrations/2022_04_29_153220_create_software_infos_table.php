<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoftwareInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('software_infos', function (Blueprint $table) {
            $table->id();
            $table->string('version', 32)->nullable();
            $table->date('lastupdate')->nullable();
            $table->string('title', 255)->nullable();
            $table->text('message')->nullable();
            $table->text('updatelink')->nullable();
            $table->text('serverlink')->nullable();
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
        Schema::dropIfExists('software_infos');
    }
}
