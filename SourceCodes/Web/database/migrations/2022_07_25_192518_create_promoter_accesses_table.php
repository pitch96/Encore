<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoterAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promoter_accesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('order_no')->nullable();
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->unsignedBigInteger('event_created_by');
            $table->foreign('event_created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('promoter_id');
            $table->foreign('promoter_id')->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('date');
            $table->double('amount')->nullable()->default(0.0);
            $table->string('payment_status', 100)->nullable();
            $table->longText('payment_response')->nullable();
            $table->string('currency', 100)->nullable();
            $table->boolean('status')->default(0)->comment('0 for pending, 1 for approved and 2 for rejected');
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
        Schema::dropIfExists('promoter_accesses');
    }
}
