<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $create_invoice = new Permission();
        $create_invoice->name = 'create_invoice';
        $create_invoice->display_name = 'Create Invoice';
        $create_invoice->description = 'Create New Invoices';
        $create_invoice->save();

        $edit_invoice = new Permission();
        $edit_invoice->name = 'edit_invoice';
        $edit_invoice->display_name = 'Edit Invoice';
        $edit_invoice->description = 'Edit Existing Invoices';
        $edit_invoice->save();


        $delete_invoice = new Permission();
        $delete_invoice->name = 'delete_invoice';
        $delete_invoice->display_name = 'Delete Invoice';
        $delete_invoice->description = 'Delete Existing Invoices';
        $delete_invoice->save();
    }
}
