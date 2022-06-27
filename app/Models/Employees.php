<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    public $directory="./img/employees/";  
    protected $table ="employees";
    protected $primaryKey ="e_id";
}
