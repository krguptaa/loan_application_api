<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepaymentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('repayment_types')) {
            Schema::create('repayment_types', function (Blueprint $table) {
                $table->bigIncrements('id');            
                $table->string('type',50)->comment='Repayment Type';
                $table->text('description')->nullable()->comment='Description';
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
        Schema::dropIfExists('repayment_types');
    }
}
