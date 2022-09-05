<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('loans')) {
            Schema::create('loans', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('user_id')->comment='User ID';
                $table->decimal('loan_amt',14,2)->comment='Loan Amount';
                $table->integer('loan_tenor')->comment='Loan Tenor';
                $table->boolean('status',1)->default(0)->comment='1=>Approved 0=>Pending';
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
        Schema::dropIfExists('loans');
    }
}
