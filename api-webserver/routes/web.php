<?php


use App\Http\Controllers\Web\WelcomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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


URL::forceScheme(config('app.proxy_schema'));


Route::get('/', [WelcomeController::class, 'index']);
Route::get('/test', [WelcomeController::class, 'test']);
//
//Route::get('/users', function () {
//    return User::with('albums')->with('photos')->paginate(5);
//});
//Route::get('/user/{user_id}', function ($user_id) {
//    //return User::(['id'=>$user_id]);
//})->where('user_id', '[0-9]+');
//Route::resource('albums', AlbumController::class);
//Route::get('/albums', [AlbumController::class,'index']);
//Route::get('/welcome-{name}', [WelcomeController::class, 'index'])->where('name', '([A-z0-9]+($|-))+');
