<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoliciesSignersReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policies_signers_references', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['Familiar','No Familiar']);
            $table->string('name', 191)->nullable();
            $table->string('email', 191)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->date('updated_at')->nullable();
            $table->unsignedBigInteger('policy_id');
            $table->unsignedBigInteger('signer_id');
            $table->foreign('policy_id')->references('id')->on('policies')->onDelete('cascade');
            $table->foreign('signer_id')->references('id')->on('signers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('policies_signers_references');
    }
}
