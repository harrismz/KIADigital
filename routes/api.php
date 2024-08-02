<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\IdentityController;
use App\Http\Controllers\IbuController;
// use App\Http\Controllers\Auth\AuthController;

// use App\Http\Controllers\ConfigController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/register', [AuthController::class, 'register']);

Route::get('/kelurahan', [LocationController::class, 'getKelurahan']);
Route::get('/kecamatan/{id}', [LocationController::class, 'getKecamatan']);
Route::get('/provinsi/{id}', [LocationController::class, 'getProvince']);

Route::get('/pendidikan', [IdentityController::class, 'getEducation']);
Route::get('/pekerjaan', [IdentityController::class, 'getJob']);
Route::get('/blood-types', [IdentityController::class, 'getBloodType']);
Route::get('/religion', [IdentityController::class, 'getReligion']);

Route::get('/get_mother/{user_id}', [IbuController::class, 'index']);
Route::get('/get_week_user', [IbuController::class, 'getWeek']);


Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::get('user', [AuthController::class, 'user'])->middleware('auth:api');
Route::get('test', [AuthController::class, 'test']);



Route::get('/pregnancy-history', [PregnancyHistoryController::class, 'index']); // Untuk menampilkan semua data pregnancy history
Route::get('/pregnancy-history/{id}', [PregnancyHistoryController::class, 'show']); // Untuk menampilkan detail data pregnancy history berdasarkan ID

