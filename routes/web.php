<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::any('{query}', 
    function() { return view('index'); })
->where('query', '.*');


// var_dump(User::all()->toArray());