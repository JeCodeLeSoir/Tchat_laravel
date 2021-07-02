<?php

//JeCodeLeSoir

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

//File -> app/http/controller/tchat/TchatController.php

Route::get('/', 'Tchat\TchatController@ShowAllMessage');
Route::get('/api/message', 'Tchat\TchatController@ShowAllMessageByJson');
Route::post('/api/send', 'Tchat\TchatController@SendMessage');
Route::get('/api/ServerSendEvent', 'Tchat\TchatController@ServerSendEvent');