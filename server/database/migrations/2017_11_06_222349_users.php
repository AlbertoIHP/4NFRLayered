<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->string('email');
        $table->string('password');
        $table->boolean('confirmed')->default(0);
        $table->string('confirmation_code')->nullable();

        $table->integer('professions_id')->unsigned()->nullable();
        $table->integer('roles_id')->unsigned()->nullable();

        $table->foreign('roles_id')->references('id')->on('roles')->onDelete('cascade');
        $table->foreign('professions_id')->references('id')->on('professions')->onDelete('cascade');

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
        Schema::dropIfExists('users');
    }
}
