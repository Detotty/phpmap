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

Route::group(['middleware' => 'forbid-banned-user'], function () {
    Route::get('/@{username}', 'Users\UserProfileController@showProfile');
    Route::get('/users', 'Site\UserController@getUsers');

    Route::get('/ug/{slug}', 'Usergroups\UsergroupController@showGroup');
    Route::get('/usergroups', 'Usergroups\UsergroupController@getGroups');
    Route::get('/roadmap', 'Site\RoadmapController@index');
    Route::get('/map', 'Sites\SiteController@getMap');
});

Route::get('/', 'Sites\SiteController@index');

Route::get('/about', 'Sites\SiteController@getAbout');
Route::get('/imprint', 'Sites\SiteController@getImprint');

Route::get('/home', 'HomeController@index');

Route::get('/auth/github', 'Auth\SocialController@redirectToGithub');
Route::get('/auth/github/callback', 'Auth\SocialController@handleGithubCallback');

Auth::routes();

Route::impersonate();
Route::feeds();
