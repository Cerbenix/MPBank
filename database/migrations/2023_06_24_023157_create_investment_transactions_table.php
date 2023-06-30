<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('investment_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('crypto_id');
            $table->string('crypto_name');
            $table->decimal('crypto_amount', 10, 2);
            $table->enum('transaction_type', ['sold', 'bought']);
            $table->decimal('balance_change', 10, 2);
            $table->timestamp('transaction_time');

            $table->foreign('account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('investment_history');
    }
}
