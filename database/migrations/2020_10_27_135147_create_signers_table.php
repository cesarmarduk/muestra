<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('company')->nullable();
            $table->string('rfc', 191)->nullable();
            $table->string('name_repre', 191)->nullable();
            $table->string('email_repre', 191)->nullable();
            $table->string('phone_repre', 191)->nullable();
            $table->string('name', 191)->nullable();
            $table->string('email', 191)->unique()->nullable();
            $table->string('email_comercia', 191)->nullable();
            $table->string('phone', 20)->nullable();
            $table->enum('type', ['Fisico', 'Moral']);
            $table->timestamp('created_at')->useCurrent();
            $table->date('updated_at')->nullable();
            $table->unsignedBigInteger('address_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('address_id')->references('id')->on('address')->onDelete('cascade');
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
        Schema::dropIfExists('signers');
    }
}
