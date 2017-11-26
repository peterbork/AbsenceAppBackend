<?php

use Illuminate\Http\Request;

Route::get('schools', "WebUntisController@GetSchools");
Route::get('teachers', "WebUntisController@GetTeachers");
Route::get('subjects', "WebUntisController@GetSubjects");
Route::get('departments', "WebUntisController@GetDepartments");
Route::get('students', "WebUntisController@GetStudents");
Route::get('lessons/weekly', "WebUntisController@GetLessonsWeekly");
Route::get('lessons/weekly/{start}/{end}', "WebUntisController@GetLessonsWeekly");
Route::get('lessons', "WebUntisController@GetLessons");

Route::get('groups', "WebUntisController@GetGroups");
Route::get('users', "WebUntisController@GetUsers");
Route::get('usergroups', "WebUntisController@GetUserGroups");