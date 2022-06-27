<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeesController as ec;
use App\Http\Controllers\ExceptionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {return view('welcome');});

Route::get('/home', [ec::class, 'index'])->name('home');
Route::post('/home', [ec::class, 'store']);
Route::get('/employees/show',[ec::class,'show']);
Route::get('/employees/delete/{eid}',[ec::class,'delete'])->name('employee.delete');;
Route::get('/employees/edit/{eid}',[ec::class,'edit'])->name('employee.edit');
Route::post('/employees/update/{eid}',[ec::class,'update'])->name('employee.update');

Auth::routes();

