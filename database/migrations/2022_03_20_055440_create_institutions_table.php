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
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('institution_type_id')->nullable();
            $table->string('name');
            $table->string('label');
            $table->string('country_id')->nullable();
            $table->string('address')->nullable();
            $table->string('telp')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('is_partner');

            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('institutions');
            $table->foreign('institution_type_id')->references('id')->on('institution_types');
            $table->foreign('country_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('institutions');
    }
};
