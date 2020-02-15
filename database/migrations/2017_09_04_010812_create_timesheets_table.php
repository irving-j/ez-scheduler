<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimesheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheets', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('employee_id')->unsigned();
            $table->integer('patient_id')->unsigned();
            $table->dateTime('date')->nullable(false);
            $table->string('time_in')->nullable(false);
            $table->string('time_out')->nullable(false);
            $table->foreign('employee_id')
                    ->references('id')->on('employees');
            $table->foreign('patient_id')
                    ->references('id')->on('patients');
            $table->index(['date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timesheets');
    }
}
