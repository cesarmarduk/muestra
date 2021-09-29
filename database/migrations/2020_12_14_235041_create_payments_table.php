<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_payment');
            $table->string('payment_type', 191);
            $table->string('order_id', 191);
            $table->string('token_id', 191)->nullable();
            $table->string('amount', 20);
            $table->string('status', 20);
            $table->string('type', 191);
            $table->timestamp('created_at')->useCurrent();
            $table->date('updated_at')->nullable();
            $table->unsignedBigInteger('contrat_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('contrat_id')->references('id')->on('contrats')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
