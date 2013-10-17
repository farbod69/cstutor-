<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	$isInstalled = Config::get('app.installed');
	if ($isInstalled)
	{
		return View::make('index',array('resp'=>'hellow world'));
	}
	else
	{
		Setting::set('username','farbod');
		Setting::set('password','test');
		dd(Setting::get());
		return View::make('setup');
	}

});