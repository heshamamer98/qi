<?php

use App\Events\commentEvent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
