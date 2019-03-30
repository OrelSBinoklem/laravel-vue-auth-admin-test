<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentJSPluginsMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_j_s_plugins_meta', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('plugin_id')->unsigned()->index();
            $table->foreign('plugin_id')->references('id')->on('content_j_s_plugins')->onDelete('cascade');

            $table->string('type')->default('null');

            $table->string('key')->index();
            $table->text('value')->nullable();

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
        Schema::dropIfExists('content_j_s_plugins_meta');
    }
}
