Route::get('role',[
'middleware' => 'Role:editor',
'uses' => 'TestController@index',
]);