<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('document',20)->unique();
            $table->string('email',70)->unique()->nullable();
            $table->string('password',400);
            $table->string('type_user',400);
            $table->date('birth')->nullable();
            $table->date('verify_birth')->default('2000-01-01');
            $table->dateTime('verify_email')->nullable();
            $table->string('state')->default('Activo');
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
        Schema::dropIfExists('users');
    }
}
