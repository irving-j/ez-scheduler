<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('last_name')->nullable(false);
            $table->string('first_name')->nullable(false);
            $table->string('initial')->nullable(true);
            $table->enum('type', ['aide','super','office']);
            $table->boolean('is_blocked')->default(0);
            $table->boolean('is_active')->default(1);
            $table->dateTime('cutoff_date')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('employees');

        Schema::table('employees', function(Blueprint $table) {
            $table->dateTime('cutoff_date')->nullable()->change();
        });
    }
}
