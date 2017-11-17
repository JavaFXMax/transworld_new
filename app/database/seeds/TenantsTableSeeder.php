<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;


class DatabaseSeeder extends Seeder {
public function run()
{
$this->call('TenantsTableSeeder');
$this->command->info('User table seeded!');
}
}


class TenantsTableSeeder extends Seeder {

	public function run()
	{
		
		$branch = new Branch;

		$branch->name = 'Head Office';
		$branch->save();


		$currency = new Currency;

		$currency->name = 'Kenyan Shillings';
		$currency->shortname = 'KES';
		$currency->save();

		

		$organization = new Organization;

		$organization->name = null;
		$organization->save();


		$share = new Share;


		$share->value = 0;
		$share->transfer_charge = 0;
		$share->charged_on = 'donor';
		$share->save();



		$perm = new Permission;

    $perm->name = 'edit_loan_product';
    $perm->display_name = 'edit loan products';
    $perm->category = 'Loanproduct';
    $perm->save();

    

    $perm = new Permission;

    $perm->name = 'view_loan_product';
    $perm->display_name = 'view loan products';
    $perm->category = 'Loanproduct';
    $perm->save();

    $perm = new Permission;

    $perm->name = 'delete_loan_product';
    $perm->display_name = 'delete loan products';
    $perm->category = 'Loanproduct';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'create_loan_account';
    $perm->display_name = 'create loan account';
    $perm->category = 'Loanaccount';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'view_loan_account';
    $perm->display_name = 'view loan account';
    $perm->category = 'Loanaccount';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'approve_loan_account';
    $perm->display_name = 'approve loan';
    $perm->category = 'Loanaccount';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'create_savingproduct';
    $perm->display_name = 'create  Product';
    $perm->category = 'Savingproduct';
    $perm->save();

    $perm = new Permission;

    $perm->name = 'view_savingproduct';
    $perm->display_name = 'view  Product';
    $perm->category = 'Savingproduct';
    $perm->save();

    $perm = new Permission;

    $perm->name = 'delete_savingproduct';
    $perm->display_name = 'Delete Product';
    $perm->category = 'Savingproduct';
    $perm->save();





    $perm = new Permission;

    $perm->name = 'disburse_loan';
    $perm->display_name = 'disburse loan';
    $perm->category = 'Loanaccount';
    $perm->save();



    $perm = new Permission;

    $perm->name = 'view_savings_account';
    $perm->display_name = 'view savings account';
    $perm->category = 'Savingaccount';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'open_saving_account';
    $perm->display_name = 'Open savings account';
    $perm->category = 'Savingaccount';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'create_member';
    $perm->display_name = 'Create Member';
    $perm->category = 'Member';
    $perm->save();

     $perm = new Permission;

    $perm->name = 'deactivate_member';
    $perm->display_name = 'Deactivate Member';
    $perm->category = 'Member';
    $perm->save();

     $perm = new Permission;

    $perm->name = 'update_member';
    $perm->display_name = 'Update Member';
    $perm->category = 'Member';
    $perm->save();



    $perm = new Permission;

    $perm->name = 'view_users';
    $perm->display_name = 'View users';
    $perm->category = 'Users';
    $perm->save();

    $perm = new Permission;

    $perm->name = 'create_users';
    $perm->display_name = 'Create users';
    $perm->category = 'Users';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'deactivate_users';
    $perm->display_name = 'Deactivate users';
    $perm->category = 'Users';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'create_roles';
    $perm->display_name = 'Create roles';
    $perm->category = 'Roles';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'view_roles';
    $perm->display_name = 'View roles';
    $perm->category = 'Roles';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'deactivate_roles';
    $perm->display_name = 'Deactivate roles';
    $perm->category = 'Roles';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'create_accounts';
    $perm->display_name = 'Create Accounts';
    $perm->category = 'Accounting';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'view_accounts';
    $perm->display_name = 'View Accounts';
    $perm->category = 'Accounting';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'deactivate_accounts';
    $perm->display_name = 'Deactivate Accounts';
    $perm->category = 'Accounting';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'create_journal';
    $perm->display_name = 'Create Journal Entry';
    $perm->category = 'Accounting';
    $perm->save();


    $perms = Permission::all();

    $pers = array();

    foreach($perms as $p){

        $pers[] = $p->id;
    }

        
    $role = new Role;

    $role->name = 'superadmin';

    $role->save();

    $role->perms()->sync($pers);


         $data = array(
            'username' => 'superadmin',
            'email' => 'superadmin@lixnet.net',
            'password' => 'superadmin',
            'password_confirmation' => 'superadmin',
            'user_type' => 'admin'

             );

        $repo = App::make('UserRepository');
        
        $user = $repo->register($data);

        $user->attachRole($role);
    
    



    
	}

}