<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageFromUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_from_users', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('album_id', 36)->index();
            $table->string('line_user_id', 36)->index();
            $table->string('message_id', 36);
            $table->unsignedSmallInteger('index');
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
        Schema::dropIfExists('image_from_users');
    }
}