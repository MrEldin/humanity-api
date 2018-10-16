<?php

namespace Humanity\Entities\Permission\Models;

use Spatie\Permission\Models\Permission as PermissionMainModel;

class Permission extends PermissionMainModel
{
    const NAME = 'name';
    const LABEL = 'label';
    const GUARD_NAME = 'guard_name';
}
