<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


#FRONTEND
Route::group(['namespace' => 'frontend'], function() {

	#AUTH
	Route::post('login', 'AuthCtrl@login')->name('api.login');
	Route::post('signup', 'AuthCtrl@signup')->name('api.signup');
	Route::post('verify', 'AuthCtrl@verify');
	Route::post('forgot', 'AuthCtrl@forgot');
	Route::post('reset', 'AuthCtrl@reset');

	#HOME
	Route::post('posts', 'AppCtrl@index');
	Route::post('post/show', 'AppCtrl@show');
	Route::post('post/comments', 'AppCtrl@comments');
	Route::post('post/comment', 'AppCtrl@createComment');
	Route::delete('post/comment', 'AppCtrl@destroyComment');

	#CONTACT US
	Route::post('contact', 'AppCtrl@contact');

});




#BACKEND
Route::group(['prefix'=>'dashboard', 'namespace'=>'backend'], function(){

	#EXPLORE
	Route::post('explore', 'DashCtrl@index');
	Route::post('row/status', 'DashCtrl@rowStatus');

	#POST
	Route::post('posts', 'PostCtrl@index');
	Route::post('post', 'PostCtrl@store');
	Route::put('post', 'PostCtrl@store');
	Route::post('post/{id}', 'PostCtrl@edit');
	Route::delete('post', 'PostCtrl@destroy');

	#COMMENTS
	Route::post('comments', 'CommentCtrl@index');
	Route::delete('comment', 'CommentCtrl@destroy');

	#MESSAGES
	Route::post('messages', 'MessageCtrl@index');
	Route::post('message/show', 'MessageCtrl@show');
	Route::delete('message', 'MessageCtrl@destroy');

	#MEMBERS
	Route::post('members', 'MemberCtrl@index');
	Route::post('member', 'MemberCtrl@store');
	Route::put('member', 'MemberCtrl@store');
	Route::delete('member', 'MemberCtrl@destroy');

	#AUTHOR
	Route::post('authors', 'AuthorCtrl@index');
	Route::post('author', 'AuthorCtrl@store');
	Route::put('author', 'AuthorCtrl@store');
	Route::delete('author', 'AuthorCtrl@destroy');
	Route::post('author/permissions', 'AuthorCtrl@permissions');

	#SETTINGS
	Route::post('settings', 'SettingCtrl@index');
	Route::put('setting', 'SettingCtrl@update');

});




