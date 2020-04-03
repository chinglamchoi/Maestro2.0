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
Route::get('/', 'PagesController@index');

Route::get('/about', 'PagesController@about');

Route::get('/users/{id}', 'PagesController@user');

Route::post('/users/about', 'PagesController@userabout');

Route::post('/users/interests', 'PagesController@userinterests');

Route::get('/add', 'PagesController@add');

Route::resource('posts', 'PostsController');

Route::post('forum/{id}/reply', 'TopicsController@reply');

Route::resource('forum', 'TopicsController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('courses/{id}/question', 'CoursesController@question');

Route::get('courses/{id}/answer', 'CoursesController@answer');

Route::get('courses/{id}/publish', 'CoursesController@publish');

Route::get('courses/{id}/start', 'CoursesController@start');

Route::post('courses/{id}/save', 'CoursesController@save');

Route::get('courses/submit', 'CoursesController@submit');

Route::get('courses/submissions', 'CoursesController@submissions');

Route::get('courses/submissions/{id}', 'CoursesController@submission');

Route::get('courses/{id}/solution', 'CoursesController@solution');

Route::get('recognition', 'CoursesController@recognition');

Route::post('recognition', 'CoursesController@recognition');

Route::resource('courses', 'CoursesController');