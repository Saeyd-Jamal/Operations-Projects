<?php

use App\Http\Controllers\FinancierController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\RecordsConstantController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::group([
    'prefix'=> '',
    'middleware' => ['auth'],
], function () {
    Route::get('/', function () {
        return redirect()->route('records.index');
    })->name('dashboard');

    Route::post('records/print', [RecordController::class, 'print'])->name('records.print');

    Route::resources([
        'records' => RecordController::class,
        'financiers' => FinancierController::class,
        'users' => UserController::class
    ]);
});
