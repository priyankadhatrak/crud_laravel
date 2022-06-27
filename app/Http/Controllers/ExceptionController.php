<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use resources\views\errors;

class ExceptionController extends Controller
{
    public function index()
    {
        // something went wrong and you want to throw CustomException
        throw new \App\Exceptions\CustomException('Something Went Wrong.');
    }
}
