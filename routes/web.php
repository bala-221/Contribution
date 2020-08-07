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

Route::get('/search', 'HomeController@search'); //search in home

Route::post('/searchContri', 'ContributionController@search')->name('searchContriRoute'); //search in create contribution blade

Route::get('/profile/sendRequest/{user}', 'profilesController@sendRequest'); //shows the profile of a user from another profile for adding friend

Route::get('profile/requestDecision', 'profilesController@decision')->name('requestDecision');



Route::get('/notification/dropDown', 'NotificationController@showDropDown');
Route::get('/notification', 'NotificationController@show');
Route::get('/notification/veiwAdashi', 'NotificationController@viewAdashiRequestBoard');




Route::post('/profile/accept_reject/{user_from}', 'profilesController@acceptOrReject');
Route::get('/profile/{user}', 'profilesController@show'); //shows the profile of a user from another profile for adding friend



Route::post('/contri', 'ContributionController@store')->name('storeContri');

Route::get('/contri/request', 'ContributionController@requestView')->name('adashiRequestView');

Route::get('/contri/request/{id}', 'ContributionController@requestDashBoard');
Route::post('/contri/request/accept', 'ContributionController@acceptRequest');


Route::group(['middleware' => 'auth'], function () {
    Route::get('contri/create', 'ContributionController@create')->name('createContri');
});
