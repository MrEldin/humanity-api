<?php

namespace Humanity\Entities\Role\Models;

use Spatie\Permission\Models\Role as RoleMainModel;

class Role extends RoleMainModel
{
    const NAME = 'name';
    const LABEL = 'label';
    const GUARD_NAME = 'guard_name';
}
