<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Auth
Route::auth();

// Custom
Route::get('/', 'HomeController@home');
Route::get('/demand', 'DemandController@index');

// Resources
Route::resource('competencies', 'CompetencyController');
Route::resource('projects', 'ProjectController');
Route::resource('users', 'UserController');
Route::resource('student.competencies', 'UserCompetenciesController');
Route::get('student/{studentId}/competencies', 'UserCompetenciesController@index');
Route::resource('students', 'StudentController');
