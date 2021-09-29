<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotarialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notarials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('address')->nullable();
            $table->text('writing')->nullable();
            $table->text('volume')->nullable();
            $table->text('book')->nullable();
            $table->date('date')->nullable();
            $table->text('notary')->nullable();
            $table->text('invoice')->nullable();
            $table->text('place')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->date('updated_at')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notarials');
    }
}
