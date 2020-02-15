<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned()->unsigned();
            $table->integer('message_id')->unsigned()->unsigned();
            $table->foreign('employee_id')->references('id')->on('employees')
                  ->onDelete('cascade');
            $table->foreign('message_id')->references('id')->on('messages')
                  ->onDelete('cascade');
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
        Schema::dropIfExists('employees_messages');
    }
}
