<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('active_principle');
            $table->string('concentration');
            $table->integer('amount');
            $table->string('pharmaceutical_form');
            $table->string('commercial_presentation');
            $table->string('medication_unit');
            $table->string('batch');
            $table->string('health_register_Invima');
            $table->date('expiration_date');
            $table->string('semaphore');
            $table->date('date_of_admission');
            $table->softDeletes();
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
        Schema::dropIfExists('produts');
    }
};
