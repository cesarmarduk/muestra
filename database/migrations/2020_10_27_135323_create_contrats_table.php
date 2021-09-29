<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['Sin Fiador','Sin Fiador - Extinción Dominio','Fiador', 'Fiador - Extinción Dominio','Obligado Solidario', 'Obligado Solidario - Extinción Dominio']);
            $table->date('date_beginning')->nullable();
            $table->boolean('has_extincion')->default(false);
            $table->boolean('has_sign')->default(false);
            $table->date('date_finish')->nullable();
            $table->string('rent_monthly', 191)->nullable();
            $table->string('payment_beginning', 191)->nullable();
            $table->string('payment_finish', 191)->nullable();
            $table->string('deposit', 191)->nullable();
            $table->text('bank_institution')->nullable();
            $table->string('bank_titular', 191)->nullable();
            $table->string('bank_account', 191)->nullable();
            $table->string('bank_clabe', 191)->nullable();
            $table->enum('use', ['Comercial', 'Habitacional', 'Industrial']);
            $table->timestamp('created_at')->useCurrent();
            $table->date('updated_at')->nullable();
            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('file_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
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
        Schema::dropIfExists('contrats');
    }
}
