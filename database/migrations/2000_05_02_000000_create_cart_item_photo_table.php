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
        Schema::create('cart_item_photo', function (Blueprint $table) {
            $table->id();
            $table->string('photo_id', 36);
            $table->string('cart_item_id', 36);
            $table->boolean('is_archived')->default(false);
            $table->timestamps();

            // foreign key
            $table->foreign('photo_id')->references('id')->on('photos')->onDelete('cascade');
            $table->foreign('cart_item_id')->references('id')->on('cart_items')->onDelete('cascade');

            // unique key
            $table->unique(['photo_id', 'cart_item_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_item_photo');
    }
};