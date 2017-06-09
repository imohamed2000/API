<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections',function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->integer('class_id')->unsigned();;
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
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
        Schema::table('sections', function(Blueprint $table){
            $table->dropForeign('sections_class_id_foreign');
            $table->dropColumn('class_id');
            $table->drop('sections');
        });

    }
}
