<?php

use Humanity\Entities\Permission\Models\Permission;
use Humanity\Entities\Role\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $adminRole = factory(Role::class)->create([
            Role::NAME       => 'super-admin',
            Role::LABEL      => 'Super admin',
            Role::GUARD_NAME => config('auth.defaults.guard'),
        ]);

        $adminRole->givePermissionTo([
            'admin-create-role',
            'admin-view-role',
            'admin-update-role',
            'admin-delete-role',
            'approve-vacation',
            'disapprove-vacation',
            'index-vacation',
            'show-vacation',
            'create-user',
            'update-user',
            'index-user',
            'show-user',
        ]);

        $userRole = factory(Role::class)->create([
            Role::NAME       => 'temp',
            Role::LABEL      => 'Temp',
            Role::GUARD_NAME => config('auth.defaults.guard'),
        ]);

        $userRole->givePermissionTo([
            'create-vacation',
            'update-vacation',
            'index-vacation',
            'show-vacation',
        ]);
    }
}
