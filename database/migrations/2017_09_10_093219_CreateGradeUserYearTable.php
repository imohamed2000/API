<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradeUserYearTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade_user',function(Blueprint $table){
            $table->increments('id');
            $table->integer('grade_id')->unsigned();
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade');
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
        Schema::table('grade_user', function(Blueprint $table){
            $table->dropForeign('grade_user_grade_id_foreign');
            $table->dropColumn('grade');
            $table->dropForeign('grade_user_user_id_foreign');
            $table->dropColumn('user_id');
            $table->dropForeign('grade_user_year_id_foreign');
            $table->dropColumn('year_id');
            $table->drop('grade_user');
        });
    }
}
