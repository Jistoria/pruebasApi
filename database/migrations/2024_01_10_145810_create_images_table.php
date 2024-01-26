<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id('id_image');
            $table->string('name_image');
            $table->string('extension');
            $table->integer('peso');
            $table->timestamps(); // Añade created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('images');
    }
};
