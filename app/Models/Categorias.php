<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Categorias extends Model
{
    protected $connection = 'mongodb';
    
    protected $collection = 'categorias';

}
