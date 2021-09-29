<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoliciesPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policies_price', function (Blueprint $table) {
            $table->increments('id');
            $table->double('price');
            $table->enum('price_type', ['$', '%']);
            $table->double('price_beginning');
            $table->double('price_finish');
            $table->timestamp('created_at')->useCurrent();
            $table->date('updated_at')->nullable(); 
            $table->unsignedInteger('policy_type_id');
            $table->foreign('policy_type_id')->references('id')->on('policies_type')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('policies_price');
    }
}
