<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planifications', function (Blueprint $table) {
            $table->id();
            $table->integer("Année");
            $table->date("DateDébut1");
            $table->date("DateFin1");
            $table->date("DateDébut2");
            $table->date("DateFin2");
            $table->date("DateDébut3")->nullable();
            $table->date("DateFin3")->nullable();
            $table->integer("VCS")->default(0);
            $table->integer("VRH")->default(0);
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
        Schema::dropIfExists('planifications');
    }
}
