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
        Schema::create('trainers', function (Blueprint $table) {
            $table->foreignId('user_id')->primary()->constrained('users', 'id');
            $table->string('ar_fname');
            $table->string('ar_mname');
            $table->string('ar_family');
            $table->string('en_fname');
            $table->string('en_mname'); 
            $table->string('en_lname'); 
            $table->string('card_id'); 
            $table->date('dob');
            $table->string('mobile');
            $table->string('specialization');
            $table->string('country');
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
        Schema::dropIfExists('trainers');
    }
};
