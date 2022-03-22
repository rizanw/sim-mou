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
            $table->unsignedBigInteger('document_type_id');
            $table->string('status');
            $table->string('number');
            $table->string('title');
            $table->text('desc')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('file')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();

            $table->timestamps();
            $table->foreign('document_type_id')->references('id')->on('document_types');
            $table->foreign('parent_id')->references('id')->on('documents');
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
