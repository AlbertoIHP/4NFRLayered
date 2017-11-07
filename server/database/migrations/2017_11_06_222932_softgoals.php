<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Softgoals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('softgoals', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->string('description');
        $table->string('time');
        $table->string('date');

        $table->integer('goals_id')->unsigned()->nullable();
        $table->integer('relevances_id')->unsigned()->nullable();

        $table->foreign('goals_id')->references('id')->on('goals')->onDelete('cascade');
        $table->foreign('relevances_id')->references('id')->on('relevances')->onDelete('cascade');

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
        Schema::dropIfExists('softgoals');
    }
}
