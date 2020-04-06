<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->string('subject')->nullable();
            $table->longText('message');
            $table->timestamp('send_at');
            $table->foreignId('user_sender_id');
            $table->foreign('user_sender_id')->references('id')->on('users');
            $table->foreignId('contact_id');
            $table->foreign('contact_id')->references('id')->on('contacts');
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
        Schema::dropIfExists('emails');
    }
}
