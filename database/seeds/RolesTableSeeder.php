<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use App\Role;
class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $owner = new Role();
        $owner->name = 'owner';
        $owner->display_name = 'Product Owner';
        $owner->description = 'Product owner is the owner of the project';
        $owner->save();

        $owner = new Role();
        $owner->name = 'admin';
        $owner->display_name = 'Admin User';
        $owner->description = 'Product owner is the owner of the project';
        $owner->save();
    }
}
