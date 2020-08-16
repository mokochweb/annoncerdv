<?php

use App\User;
use Illuminate\Support\Facades\Route;
use App\Notifications\NewPostNotification;

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
Route::get('/welcome', 'Controller@index')->name('welcome');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/contact_us', 'HomeController@contact_us');
Route::post('/contact_us', 'HomeController@post_contact_us');

Route::get('/about_us', 'HomeController@about_us');
Route::get('/profile/{id?}', 'HomeController@profile')->name('profile');
Route::get('posts/my_ads', 'PostController@my_ads');
Route::resource('users', 'UserprofileController');
Route::resource('posts', 'PostController');
Route::get('posts/delete/{id}', 'PostController@delete')->name('posts.delete');
Route::post('/update/posts/{id}', 'PostController@update2')->name('posts.update1');
Route::resource('news', 'NewsController');
Route::get('news/delete/{id}', 'NewsController@delete')->name('news.delete');
Route::post('news/update/{id}', 'NewsController@update')->name('news.update');
Route::get('/adress/{adress}', 'PostController@ajaxadress');

Route::get('posts/messages', 'PostController@getMessages')->name('news.post.message');
Route::post('posts/messages', 'NewsController@postMessage')->name('news.post.message');

Route::get('settings', 'SettingController@index')->name('settings.index');
Route::post('settings', 'SettingController@update')->name('settings.update');
Route::resource('messages', 'MessageController');
Route::post('messages.new-message/{id}', 'MessageController@newMessage')->name('messages.new-message');
Route::post('message.all', 'MessageController@messageAll')->name('message.all');
Route::post('message/send', 'MessageController@sendMessage')->name('message.send');
Route::get('message/post/info/{id}', 'MessageController@messagePostInfo')->name('message.post.info');
Route::post('message/post/group', 'MessageController@messageGroup')->name('message.post.group');
Route::post('message/delete/list', 'MessageController@deleteMessage')->name('message.delete.list');
Route::get('message/get/data', 'MessageController@getData')->name('message.get.data');

//Route::post('messages.read-message', 'MessageController@readMessage')->name('messages.read-message');
Route::get('messages.read-message', 'MessageController@readMessage')->name('messages.read-message');

Route::post('posts/myposts/{id}', 'PostController@update2')->name('posts.update1');
