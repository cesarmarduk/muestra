<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('folio', 50)->nullable();
            $table->enum('type', ['Sin Fiador','Fiador','Obligado Solidario']);
            $table->date('date_beginning')->nullable();
            $table->date('date_finish')->nullable();
            $table->string('cost', 20);
            $table->string('rent_monthly', 191)->nullable();
            $table->string('payment_beginning', 191)->nullable();
            $table->string('payment_finish', 191)->nullable();
            $table->string('deposit', 191)->nullable();
            $table->text('bank_institution')->nullable();
            $table->string('bank_titular', 191)->nullable();
            $table->string('bank_account', 191)->nullable();
            $table->string('bank_clabe', 191)->nullable();
            $table->enum('use', ['Comercial', 'Habitacional', 'Industrial']);
            $table->enum('status', ['Creada','Solicitud', 'En Proceso', 'Autorizada', 'Activa', 'Rechazada', 'Cancelada']);
            $table->timestamp('created_at')->useCurrent();
            $table->date('updated_at')->nullable(); 
            $table->unsignedInteger('policy_type_id');
            $table->unsignedBigInteger('contrat_id');
            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('policy_type_id')->references('id')->on('policies_type')->onDelete('cascade');
            $table->foreign('contrat_id')->references('id')->on('contrats')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
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
        Schema::dropIfExists('policies');
    }
}
