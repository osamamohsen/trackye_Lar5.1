<?php

use App\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Facker;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $facker = Facker::create();

        foreach(range(1,50) as $index){
            User::create([
                'name' => $facker->name.$index,
                'email' => $facker->email,
                'password' =>bcrypt('secret')
            ]);
        }//end foreach
    }
}
