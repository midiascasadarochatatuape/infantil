<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('date_modifications', function (Blueprint $table) {
            $table->string('message')->nullable();
        });
    }

    public function down()
    {
        Schema::table('date_modifications', function (Blueprint $table) {
            $table->dropColumn('message');
        });
    }
};