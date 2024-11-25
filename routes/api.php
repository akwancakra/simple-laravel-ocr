<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::post('/ocr', [MainController::class, 'ocr']);
