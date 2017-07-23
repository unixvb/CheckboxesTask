<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkbox extends Model
{
    protected  $fillable = [
        'checkbox_row',
        'checkbox_col'
    ];
}
