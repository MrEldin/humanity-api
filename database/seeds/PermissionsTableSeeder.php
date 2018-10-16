<?php

use Illuminate\Database\Seeder;
use Humanity\Entities\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        // reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        $permissions = [
            //Roles
            [
                Permission::NAME       => 'admin-create-role',
                Permission::LABEL      => 'Create role',
                Permission::GUARD_NAME => config('auth.defaults.guard')
            ],
            [
                Permission::NAME       => 'admin-view-role',
                Permission::LABEL      => 'View role',
                Permission::GUARD_NAME => config('auth.defaults.guard')
            ],
            [
                Permission::NAME       => 'admin-update-role',
                Permission::LABEL      => 'Update role',
                Permission::GUARD_NAME => config('auth.defaults.guard')
            ],
            [
                Permission::NAME       => 'admin-delete-role',
                Permission::LABEL      => 'Delete role',
                Permission::GUARD_NAME => config('auth.defaults.guard')
            ],
            [
                Permission::NAME       => 'create-vacation',
                Permission::LABEL      => 'create vacation',
                Permission::GUARD_NAME => config('auth.defaults.guard')
            ],
            [
                Permission::NAME       => 'update-vacation',
                Permission::LABEL      => 'update vacation',
                Permission::GUARD_NAME => config('auth.defaults.guard')
            ],
            [
                Permission::NAME       => 'approve-vacation',
                Permission::LABEL      => 'approve vacation',
                Permission::GUARD_NAME => config('auth.defaults.guard')
            ],
            [
                Permission::NAME       => 'disapprove-vacation',
                Permission::LABEL      => 'disapprove vacation',
                Permission::GUARD_NAME => config('auth.defaults.guard')
            ],
            [
                Permission::NAME       => 'index-vacation',
                Permission::LABEL      => 'index vacation',
                Permission::GUARD_NAME => config('auth.defaults.guard')
            ],
            [
                Permission::NAME       => 'show-vacation',
                Permission::LABEL      => 'show vacation',
                Permission::GUARD_NAME => config('auth.defaults.guard')
            ]

        ];

        app('db')->table('permissions')->insert($permissions);
    }
}
