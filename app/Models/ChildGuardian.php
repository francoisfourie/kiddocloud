<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChildGuardian extends Pivot
{
    //
    public $table = 'children_guardians';
}
