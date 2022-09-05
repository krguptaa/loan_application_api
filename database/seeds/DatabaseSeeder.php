<?php

use Database\TruncateTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use TruncateTable;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        Model::unguard();

        $this->truncateMultiple([
            'cache',
            'sessions',
        ]);

        $this->call(AuthTableSeeder::class);

        $this->call(RepaymentTypeTableSeeder::class);
        
        Model::reguard();
    }
}
