<?php

use App\Http\Controllers\ExcelSplitController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ExcelSplitController::class, 'index'])->name('excel.split.form');
Route::post('/excel-split', [ExcelSplitController::class, 'splitExcelFile'])->name('excel.split');

