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
            $table->id();
            $table->string('Matricule');
            $table->string('Nom');
            $table->string('Prénom');
            $table->string('Adresse');
            $table->string('NumTel');
            $table->string('CIN');
            $table->string('nbTotal')->default(22);
            $table->unsignedBigInteger("IdService");
            $table->foreign("IdService")->references("id")->on("services");
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
