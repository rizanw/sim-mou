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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->integer('document_type_id');
            $table->string('number');
            $table->string('title');
            $table->string('desc');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('file');
            $table->integer('institute_id');

            $table->timestamps();
            $table->foreign('document_type_id')->references('id')->on('document_types');
            $table->foreign('institute_id')->references('id')->on('institutes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
