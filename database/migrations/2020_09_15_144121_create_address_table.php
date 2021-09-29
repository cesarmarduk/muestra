<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('address')->nullable();
            $table->text('exterior')->nullable();
            $table->text('interior')->nullable();
            $table->text('colonia')->nullable();
            $table->string('postal_code', 191)->nullable();
            $table->enum('status', ['Active', 'Inactive']);
            $table->timestamp('created_at')->useCurrent();
            $table->date('updated_at')->nullable(); 
            $table->unsignedInteger('municipality_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('municipality_id')->references('id')->on('municipalities')->onDelete('cascade');
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
        Schema::dropIfExists('address');
    }
}
