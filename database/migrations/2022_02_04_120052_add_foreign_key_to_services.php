<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToServices extends Migration
{
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->foreign("IdCS")->references("id")->on("users");
        });
    }

    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign(['IdCS']);
        });
    }
}
