<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id', 36);
            $table->enum('status', ['default', 'confirmed', 'shipping', 'shipped'])->default('default');
            $table->string('user_id', 33);
            $table->string('album_id', 36);
            $table->enum('type', ['simple', 'casual', 'minimal']);
            $table->boolean('self_print');
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
        Schema::dropIfExists('orders');
    }
};
