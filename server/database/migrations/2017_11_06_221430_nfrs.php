<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Nfrs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nfrs', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->string('description');

        $table->integer('categories_id')->unsigned()->nullable();

        $table->foreign('categories_id')->references('id')->on('categories')->onDelete('cascade');



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
        Schema::dropIfExists('nfrs');
    }
}
