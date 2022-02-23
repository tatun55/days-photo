<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->enum('status', ['default', 'uploading', 'uploaded'])->default('default');
            $table->string('line_user_id', 33)->index();
            $table->string('title', 50)->nullable();
            $table->unsignedSmallInteger('total')->default(0);
            $table->date('delete_date')->nullable();
            $table->string('cover', 36)->default(null)->nullable();
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
        Schema::dropIfExists('albums');
    }
}