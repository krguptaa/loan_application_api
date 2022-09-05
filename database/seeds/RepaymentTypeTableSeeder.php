<?php

use Database\TruncateTable;
use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

/**
 * Class RepaymentTypeTableSeeder.
 */
class RepaymentTypeTableSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();
        $this->truncate('repayment_types');

        $repaymentTypes = array(
            array('id' => 1,'type' => 'EMIs','description' => "EMIs Repayement Type", "created_at" => Carbon::now(), "updated_at" => Carbon::now())
        );

        DB::table('repayment_types')->insert($repaymentTypes);

        $this->enableForeignKeys();
    }
}
