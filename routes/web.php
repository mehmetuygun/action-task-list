<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {
	Route::prefix('api/')->group(function () {
		Route::get('get/action', 'Api\ActionController@getAction');
		Route::post('post/action', 'Api\ActionController@saveAction');
		Route::post('uncomplete/action/{id}', 'Api\ActionController@uncompleteAction');
	});
	Route::get('download/photo/{id}', function($id) {
		$action = App\Action::find($id);
		if ($action) {
			$file = storage_path('app/photos/'.$id.'/'.$action->file_name);
			if (file_exists($file)) {
				return response()->download($file);
			}
			return redirect()->back();
		}
	});
});