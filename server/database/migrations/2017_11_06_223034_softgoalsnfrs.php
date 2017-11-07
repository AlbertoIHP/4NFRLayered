<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Softgoalsnfrs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('softgoalsnfrs', function (Blueprint $table) {
        $table->increments('id');
        $table->string('time');
        $table->string('date');

        $table->integer('softgoals_id')->unsigned()->nullable();
        $table->integer('nfrs_id')->unsigned()->nullable();

        $table->foreign('softgoals_id')->references('id')->on('softgoals')->onDelete('cascade');
        $table->foreign('nfrs_id')->references('id')->on('nfrs')->onDelete('cascade');

        $table->rememberToken();
        $table->timestamps();
        $table->timestamp('deleted_at')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('softgoalsnfrs');
    }
}
