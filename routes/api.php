<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IbuController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\IdentityController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CheckupController;
use App\Http\Controllers\ChildDevelopmentHistoryController;
use App\Http\Controllers\ChildMonitoringController;
use App\Http\Controllers\ImunisasiController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\PregnancyHistoryController;
use App\Http\Controllers\VaksinController;
use App\Http\Controllers\ComboController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\PregnancyController;
use App\Http\Controllers\PregnancyMonitoringController;
use App\Http\Controllers\StuntingAnalysisController;
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
Route::get('/kecamatan', [LocationController::class, 'getAllKecamatan']);
Route::get('/kecamatan/{id}', [LocationController::class, 'getKecamatan']);
Route::get('/provinsi/{id}', [LocationController::class, 'getProvince']);

Route::get('/pendidikan', [IdentityController::class, 'getEducation']);
Route::get('/pekerjaan', [IdentityController::class, 'getJob']);
Route::get('/blood-types', [IdentityController::class, 'getBloodType']);
Route::get('/religion', [IdentityController::class, 'getReligion']);
Route::post('/identitas-ibu', [IdentityController::class, 'store']);
Route::post('/identitas-ayah', [IdentityController::class, 'storeAyah']);
Route::get('/combo/{modelname}', [ComboController::class, 'get']);

Route::get('/get_mother/{user_id}', [IbuController::class, 'index']);
Route::get('/get_week_user', [IbuController::class, 'getWeek']);

Route::get('/post', [PostController::class, 'index']);
Route::get('/post/{slug}', [PostController::class, 'show']);

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::get('user', [AuthController::class, 'user'])->middleware('auth:api');
Route::get('test', [TestController::class, 'test']);

Route::get('/checkup/{guid}', [CheckupController::class, 'get'])->name('checkup.get'); //untuk menampilan semua data checkup based on guid mother or children
Route::post('/checkup', [CheckupController::class, 'store'])->name('checkup.store'); // save data checkup
Route::get('/checkup', [CheckupController::class, 'index'])->name('checkup.index'); // save data checkup

Route::get('/vaksin/combo', [VaksinController::class, 'combo'] )->name('vaksin.combo');
Route::post('/imunisasi', [ImunisasiController::class, 'store'] )->name('imunisasi.store');
Route::get('/imunisasi/{child_id}', [ImunisasiController::class, 'showVaccinePerChild'] )->name('imunisasi.get');

Route::post('/pregnancy', [PregnancyController::class, 'store']); // Untuk menampilkan semua data pregnancy history
Route::get('/pregnancy/{mother_id}', [PregnancyController::class, 'show']); // Untuk menampilkan semua data pregnancy history


Route::get('/pregnancy-history', [PregnancyHistoryController::class, 'index']); // Untuk menampilkan semua data pregnancy history
Route::get('/pregnancy-history/{id}', [PregnancyHistoryController::class, 'show']); // Untuk menampilkan detail data pregnancy history berdasarkan ID
Route::get('/pregnancy-history/week/{week}', [PregnancyHistoryController::class, 'showByWeek']);
Route::get('/pregnancy-history-last', [PregnancyHistoryController::class, 'showLast']);

// route anak
Route::get('/child-development-history/{id}', [ChildDevelopmentHistoryController::class, 'index']);
Route::get('/child-development-detail/{id}', [ChildDevelopmentHistoryController::class, 'show']);
// mif, I need the api to always retur 'success' & 'data' key, not immediately return the result query
Route::get('/child-dev-history/{id}', [ChildDevelopmentHistoryController::class, 'showData']);

// StuntingAnalysis
Route::get('stunting-analysis', [StuntingAnalysisController::class, 'index']);

// weekly child questions
Route::get('/questions/{period_id}', [ ChildMonitoringController::class, 'show' ]);
Route::post('/questions', [ ChildMonitoringController::class, 'store' ]);

Route::get('/periods/{id}', [ PeriodController::class, 'show' ]);

// weekly pregnancy questions
Route::get('/pregnancy-questions/{week_number}', [PregnancyMonitoringController::class, 'show']);
Route::post('/pregnancy-questions', [PregnancyMonitoringController::class, 'store']);
Route::get('/pregnancy-week-number/{mother_id}', [PregnancyMonitoringController::class, 'getWeekPregnancyNumber']);