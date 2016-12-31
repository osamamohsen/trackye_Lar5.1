<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->cleanDataBase();	/* possible to clean DB table */

        $this->call(UsersTableSeeder::class);

        Model::reguard();
    }

    protected $tables = ['users'];

    private function cleanDataBase()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach($this->tables as $table){
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
