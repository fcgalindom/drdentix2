<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->time("hour_strart")->nullable();
            $table->time("hour_end")->nullable();
            $table->boolean("break")->nullable();
            $table->time("break_strart")->nullable();
            $table->time("break_end")->nullable();
            $table->boolean("attend");
            $table->integer("day");

            $table->foreignId('dentistF')->constrained('dentists');
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
        Schema::dropIfExists('schedules');
    }
}
