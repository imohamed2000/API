<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files',function(Blueprint $table){

            $table->increments('id');
            $table->string('filename');
            $table->string('original_name');
            $table->string('type');
            $table->integer('size');
            $table->integer('extension');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools', function(Blueprint $table){
            $table->dropForeign('schools_logo_id_foreign');
            $table->dropColumn('logo_id');
        });
        Schema::dropIfExists('files');
    }
}
