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
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->unique()->constrained();
            $table->foreignId('email_header_id')->constrained('email_headers');
            $table->foreignId('email_styles_id')->constrained('email_styles');
            $table->string('header_color');
            $table->string('image_logo')->nullable();
            $table->text('body');
            $table->string('button_color');
            $table->string('button_text');
            $table->text('footer_text');
            $table->boolean('helper_text');
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
};
