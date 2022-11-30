<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->date('day');
            $table->string('hour');
            $table->foreignId('branchesF')->constrained('branches');
            $table->foreignId('patientsF')->constrained('patients');
            $table->unsignedBigInteger('dentistProceduresF');
            $table->foreign('dentistProceduresF')->references('id')->on('dentistProcedures');
            $table->string('state')->default('Activo');
            $table->double('pay')->default(0);
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
        Schema::dropIfExists('appointments');
    }
}
