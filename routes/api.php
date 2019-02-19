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

Route::delete('users/{id}', function ($id) {
    $user = App\User::findOrFail($id);

    if ($user->type === 'admin') {
        return response(['The users admin can`t delete'], 400);
    }

    $user->delete();

    return response(['oki'], 202);
});
