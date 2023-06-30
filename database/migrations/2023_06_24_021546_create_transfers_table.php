<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_account_id');
            $table->unsignedBigInteger('receiver_account_id');
            $table->decimal('sender_amount', 10, 2);
            $table->decimal('receiver_amount', 10, 2);
            $table->string('description')->nullable();
            $table->timestamp('transfer_time');

            $table->foreign('sender_account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('cascade');

            $table->foreign('receiver_account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('account_history');
    }
}
