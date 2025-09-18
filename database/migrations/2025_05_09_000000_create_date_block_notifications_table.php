<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('date_block_notifications', function (Blueprint $table) {
            $table->id();
            $table->date('blocked_date');
            $table->integer('block_count');
            $table->boolean('notified')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('date_block_notifications');
    }
};