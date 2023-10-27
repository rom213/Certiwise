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
        Schema::create('view_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->unique();
            $table->string('certificate_name');
            $table->string('event_description')->nullable();
            $table->string('criteria_for_obtaining')->nullable();
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
        Schema::dropIfExists('view_pages');
    }
};
