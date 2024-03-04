<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->string('ticket_title');
            $table->enum('ticket_type', ['Paid', 'Free']);
            $table->bigInteger('quantity');
            $table->double('price')->default(0.00)->nullable();
            // $table->date('start_date');
            // $table->string('start_time');
            $table->date('end_date');
            $table->string('end_time');
            $table->boolean('status')->default(1)->comment('0 for inactive ticket and 1 for active ticket');
            $table->softDeletes();
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
        Schema::dropIfExists('tickets');
    }
}
