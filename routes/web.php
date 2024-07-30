<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ConfigController;
// use App\Http\Controllers\Auth\CustomLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('app');
// })
// ->name('application');

// Route::get('/', function () {
//     if(!Auth::check()){
//         return redirect('/admin/login');
//     }
//     return redirect('/');
//     // return redirect()->intended('/');
//     // return Auth::check() ? 'Authenticated' : 'Not Authenticated';
// });

Route::get('/check-auth', function(){
    return Auth::check()? 'Authenticated' : 'Not Authenticated';
});

Route::get('/user', function () {
    return response()->json([
        'user' => Auth::guard('web')->user(), // Menggunakan guard 'web'
    ]);
})->middleware('admin.user'); // Middleware 'admin.user' dari Voyager

Route::get('/config', [ConfigController::class, 'getAppUrl']);

// Auth::routes();

// // Route::get('/login', function () {
// //     return view('auth.login');
// // })->name('login');

// // Route::post('/login', [CustomLoginController::class, 'login']);

// // Route::redirect('/login', '/admin/login');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::post('/logout',[AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::view('/{any}', 'welcome')->where('any', '.*');
