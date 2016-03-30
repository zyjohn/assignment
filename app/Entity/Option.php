<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'product_option';
    protected $primaryKey = 'id';

    //public $timestamps = false;
}
