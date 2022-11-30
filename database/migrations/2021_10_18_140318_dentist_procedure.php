<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DentistProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('dentistProcedures', function (Blueprint $table) {
            $table->bigIncrements('id');


            $table->unsignedBigInteger('proceduresF');
            $table->foreign('proceduresF')->references('id')->on('procedures');
            $table->unsignedBigInteger('dentistsF');
            $table->foreign('dentistsF')->references('id')->on('dentists');



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
        Schema::dropIfExists('dentistprocedures');
    }
}
