<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Shareds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shareds', function (Blueprint $table) {
        $table->increments('id');

        $table->integer('users_id')->unsigned()->nullable();
        $table->integer('projects_id')->unsigned()->nullable();

        $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('projects_id')->references('id')->on('projects')->onDelete('cascade');

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
        Schema::dropIfExists('shareds');
    }
}
