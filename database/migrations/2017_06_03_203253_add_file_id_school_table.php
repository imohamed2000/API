<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFileIdSchoolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('schools',function(Blueprint $table){
            $table->integer('logo_id')->unsigned()->default('3')->after('zip');
            $table->foreign('logo_id')->references('id')->on('files')->onDelete('cascade');
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
    }
}
