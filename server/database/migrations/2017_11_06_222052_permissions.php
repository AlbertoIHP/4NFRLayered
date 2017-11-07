<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Permissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
        $table->increments('id');
        $table->string('write')->default(0);
        $table->string('erase')->default(0);
        $table->string('update')->default(0);
        $table->string('view')->default(0);

        $table->integer('roles_id')->unsigned()->nullable();
        $table->integer('functionalities_id')->unsigned()->nullable();

        $table->foreign('roles_id')->references('id')->on('roles')->onDelete('cascade');
        $table->foreign('functionalities_id')->references('id')->on('functionalities')->onDelete('cascade');

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
        Schema::dropIfExists('permissions');
    }
}
