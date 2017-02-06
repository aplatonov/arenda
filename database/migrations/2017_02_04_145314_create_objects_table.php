<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('object_name', 191)->unique();
            $table->text('description');
            $table->string('images', 250)->nullable();
            $table->integer('category_id')->unsigned();
            $table->integer('year')->unsigned();
            $table->string('name_period', 20)->nullable();
            $table->integer('min_period')->unsigned();
            $table->float('price', 10,2);
            $table->integer('owner_id')->unsigned();
            $table->datetime('free_since');
            $table->boolean('disabled')->default(false);
            $table->integer('customer_id')->unsigned()->nullable();
            $table->timestamps();
        });


        Schema::table('objects', function (Blueprint $table) {
            $table->foreign('owner_id')->references('id')->on('users')
                        ->onDelete('restrict')
                        ->onUpdate('cascade');
            $table->foreign('category_id')->references('id')->on('categories')
                        ->onDelete('restrict')
                        ->onUpdate('cascade');
            $table->foreign('customer_id')->references('id')->on('users')
                        ->onDelete('restrict')
                        ->onUpdate('cascade');

        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('objects', function (Blueprint $table) {
            $table->dropForeign('lots_owner_id_foreign');
            $table->dropForeign('lots_category_id_foreign');
            $table->dropForeign('lots_customer_id_foreign');
        });

        Schema::drop('objects');
    }
}
