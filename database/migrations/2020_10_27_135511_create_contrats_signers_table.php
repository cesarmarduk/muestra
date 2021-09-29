<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratsSignersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrats_signers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['Propietario','Inquilino','Fiador','Obligado Solidario']);
            $table->timestamp('created_at')->useCurrent();
            $table->date('updated_at')->nullable();
            $table->unsignedBigInteger('contrat_id');
            $table->unsignedBigInteger('signer_id');
            $table->unsignedBigInteger('notarial_id')->nullable();
            $table->foreign('contrat_id')->references('id')->on('contrats')->onDelete('cascade');
            $table->foreign('signer_id')->references('id')->on('signers')->onDelete('cascade');
            $table->foreign('notarial_id')->references('id')->on('notarials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contrats_signers');
    }
}
