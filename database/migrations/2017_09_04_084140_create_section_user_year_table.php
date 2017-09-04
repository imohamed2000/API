<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionUserYearTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_user_year',function(Blueprint $table){
            $table->increments('id');
            $table->integer('section_id')->unsigned();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('year_id')->unsigned();
            $table->foreign('year_id')->references('id')->on('years')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('section_user_year', function(Blueprint $table){
            $table->dropForeign('section_user_year_section_id_foreign');
            $table->dropColumn('section_id');
            $table->dropForeign('section_user_year_user_id_foreign');
            $table->dropColumn('user_id');
            $table->dropForeign('section_user_year_year_id_foreign');
            $table->dropColumn('year_id');
            $table->drop('section_user_year');
        });
    }
}
