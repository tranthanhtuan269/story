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

Route::get('/privacy-policy', function () {
    return view('privacy_policy');
});


Route::get('/terms-of-service', function () {
    return view('terms_of_service');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/unapproved/{slug}', 'UnapprovedController@slug')->name('unapproved.slug');
Route::get('/unapproved/{id}/view', 'UnapprovedController@show')->name('unapproved.show');
Route::get('/unapproved/{id}/edit', 'UnapprovedController@edit')->name('unapproved.edit');
Route::put('/unapproved/{id}', 'UnapprovedController@update')->name('unapproved.update');
Route::post('/unapproved/{id}/approve', 'UnapprovedController@approve')->name('unapproved.approve');
Route::post('/unapproved/{id}/store', 'UnapprovedController@store')->name('unapproved.store');
Route::delete('/unapproved/{id}', 'UnapprovedController@destroy')->name('unapproved.destroy');
Route::get('/slug', 'HomeController@slug')->name('slug');

Route::get('/categories/{slug}', 'CategoryController@slug')->name('categories.slug');
Route::get('/stories/{slug}', 'StoryController@slug')->name('stories.slug');
Route::delete('/stories/{id}', 'StoryController@destroy')->name('stories.destroy');

Route::resource('categories', 'CategoryController');

Route::post('images/uploadImage',['as' => 'uploadImage', 'uses' => 'HomeController@uploadImage']);
