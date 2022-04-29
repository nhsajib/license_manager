<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FormDataController extends Controller
{
    public function users(){
        if(auth()->user()->type == 1){
            return User::select('id', 'email')->get();
        }else{
            return User::select('id', 'email')->where('createdby', auth()->user()->id)->get();
        }
    }
}
