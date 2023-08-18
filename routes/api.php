<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Models\Document;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', [DocumentController::class, 'index'])->name('index');
Route::post('/store', [DocumentController::class, 'store'])->name('store');
Route::delete('/delete/{id}', [DocumentController::class, 'destroy'])->name('destroy');
Route::patch('/update/', [DocumentController::class, 'update'])->name('update');
Route::get('/show/{id}', [DocumentController::class, 'show'])->name('show');
Route::get('/generate_pdf/{id}', [DocumentController::class, 'generate_pdf'])->name('generate_pdf');



