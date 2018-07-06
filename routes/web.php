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

Route::get('/', 'PagesController@home');//->middleware('secureHttp');
Route::get('/messages/{message}', 'MessagesController@show');

Auth::routes();

Route::get('/auth/{social}','SocialAuthController@social');
Route::get('/auth/{social}/callback','SocialAuthController@callback');
Route::post('/auth/{social}/register','SocialAuthController@register');

Route::get('/home','HomeController@index'  );
Route::get('/messages','MessagesController@search'  );

Route::group(['middleware' => 'auth'], function(){
    Route::post('/messages/create', 'MessagesController@create');
    Route::get('/profile', 'UsersController@profile');
    Route::post('/{username}/follow','UsersController@follow');
    Route::post('/{username}/unfollow','UsersController@unfollow');
    Route::post('/{username}/dms','UsersController@sendPrivateMessage'  );
    Route::get('/conversations/{conversation}','UsersController@showConversation'  );
});
Route::get('/{username}/follows','UsersController@follows');
Route::get('/{username}/followers','UsersController@followers');
Route::get('/{username}','UsersController@show'  );

