<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('request_name', 191)->unique();
            $table->text('comment');
            $table->integer('category_id')->unsigned();
            $table->datetime('start_date')->nullable();
            $table->datetime('finish_date')->nullable();
            $table->integer('owner_id')->unsigned();
            $table->integer('customer_id')->unsigned()->nullable();
            $table->boolean('disabled')->default(false);
            $table->timestamps();
        });


        Schema::table('requests', function (Blueprint $table) {
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
        Schema::table('requests', function (Blueprint $table) {
            $table->dropForeign('requests_owner_id_foreign');
            $table->dropForeign('requests_category_id_foreign');
            $table->dropForeign('requests_customer_id_foreign');
        });

        Schema::drop('requests');
    }
}
