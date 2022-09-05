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
        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('payment_meta_id')->comment='Payment Meta Id';
                $table->decimal('amount_received',14,2)->comment='Amount Received';
                $table->boolean('payment_status',1)->default(1)->comment='1=>Received 0=>Confirm with Payment Gateway';
                $table->bigInteger('created_by')->nullable()->Comment='Created By';
                $table->timestamps();
                $table->softDeletes();

            });
        }
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
