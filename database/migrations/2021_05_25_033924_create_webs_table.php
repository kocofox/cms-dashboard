<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webs', function (Blueprint $table) {
            $table->id();
            $table->String('titulo');
            $table->longText('descripcion')->nullable();
            $table->json('etiquetas')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->json('redes')->nullable();
            $table->string('nosotros')->nullable();
            $table->string('mision')->nullable();
            $table->string('vision')->nullable();
            $table->json('footer')->nullable();
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
        Schema::dropIfExists('webs');
    }
}
