<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConnectionTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connection_tests', function (Blueprint $table) {
            $table->id();
            $table->boolean('completed')->default(false);
            $table->longText('output')->nullable();
            $table->integer('return_code')->nullable();
            $table->boolean('up')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('connection_tests');
    }
}
