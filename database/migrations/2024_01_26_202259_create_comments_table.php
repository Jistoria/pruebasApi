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
        Schema::create('comments', function (Blueprint $table) {
            $table->id('id_comment');
            $table->text('content');
            $table->unsignedBigInteger('id_issuing');
            $table->unsignedBigInteger('id_receptor');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('id_issuing')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_receptor')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
