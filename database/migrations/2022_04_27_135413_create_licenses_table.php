<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->string('keyid', 100);
            $table->string('username', 100);
            $table->string('macaddress', 100)->nullable();
            $table->timestamp('create_date');
            $table->date('expire_date');
            $table->bigInteger('createbyid');
            $table->string('createdby', 100)->nullable();
            $table->tinyInteger('status');
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
        Schema::dropIfExists('licenses');
    }
}
