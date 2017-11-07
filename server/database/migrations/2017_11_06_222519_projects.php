<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Projects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->string('description');
        $table->string('time');
        $table->string('date');
        $table->string('deadline');

        $table->integer('users_id')->unsigned()->nullable();
        $table->integer('areas_id')->unsigned()->nullable();

        $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('areas_id')->references('id')->on('areas')->onDelete('cascade');

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
        Schema::dropIfExists('projects');
    }
}
