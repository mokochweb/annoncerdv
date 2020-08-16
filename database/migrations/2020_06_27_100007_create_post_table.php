<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titre');
            $table->unsignedBigInteger('qte');
            $table->unsignedBigInteger('quantite2');
            $table->date('daterdvbegin')->nullable();
            $table->date('daterdvend')->nullable();
            $table->time('Hbeginrdv')->nullable();
            $table->time('Hendrdv')->nullable();
            $table->string('adresse');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
