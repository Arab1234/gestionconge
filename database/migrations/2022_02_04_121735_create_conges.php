<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conges', function (Blueprint $table) {
            $table->id();
            $table->date("DateDébut");
            $table->integer("nbJour");
            $table->integer("VCS")->default(0);
            $table->integer("VRH")->default(0);
            $table->unsignedBigInteger("IdType")->nullable();
            $table->foreign("IdType")->references("id")->on("typeconges");
            $table->unsignedBigInteger("IdPlan")->nullable();
            $table->foreign("IdPlan")->references("id")->on("planifications");
            $table->unsignedBigInteger("IdUser")->nullable();
            $table->foreign("IdUser")->references("id")->on("users");
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
        Schema::dropIfExists('conges');
    }
}
