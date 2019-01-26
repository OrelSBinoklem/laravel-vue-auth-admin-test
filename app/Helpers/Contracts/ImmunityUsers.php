<?php

namespace App\Helpers\Contracts;

use Illuminate\Database\Eloquent\Model;
//use App\Model;

Interface ImmunityUsers
{
    public function immunityIsHigherForPermission($permissions, $users, $require = FALSE, $equal = TRUE);
    public function immunityIsHigherForAccessToModel($permissions, Model $model, $require = FALSE, $equal = TRUE);
}