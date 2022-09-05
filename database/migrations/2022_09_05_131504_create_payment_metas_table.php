<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payment_metas')) {
            Schema::create('payment_metas', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('loan_id')->comment='Loan Id';
                $table->bigInteger('repayment_type_id')->comment='Repayment Type Id';
                $table->decimal('installment_amount',14,2)->comment='Installment Received';
                $table->decimal('pending_amount',14,2)->comment='Pending Received';

                $table->datetime('last_repayment_date')->nullable()->comment='Last Repayment Date';

                $table->datetime('next_repayment_date')->nullable()->comment='Next Repayment Date';

                $table->boolean('status',1)->default(1)->comment='1=>Active 0=>Inactive';
               
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
        Schema::dropIfExists('payment_metas');
    }
}
