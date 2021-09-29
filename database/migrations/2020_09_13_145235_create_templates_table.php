<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 191)->unique();
            $table->string('name', 191);
            $table->longtext('template');
            $table->enum('status', ['Active', 'Inactive']);
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
        Schema::dropIfExists('templates');
    }
}
