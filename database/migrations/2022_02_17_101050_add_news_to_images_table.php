<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewsToImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->bigInteger('servicio_id')->unsigned()->after('post_id');
            $table->bigInteger('noticia_id')->unsigned()->after('servicio_id');
            $table->bigInteger('trabajo_id')->unsigned()->after('noticia_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn('servicio_id');
            $table->dropColumn('noticia_id');
            $table->dropColumn('trabajo_id');
        });
    }
}
