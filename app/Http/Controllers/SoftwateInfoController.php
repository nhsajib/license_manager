<?php

namespace App\Http\Controllers;

use App\Models\SoftwareInfo;
use Illuminate\Http\Request;

class SoftwateInfoController extends Controller
{
    public function get(){

        if(auth()->user()->type != 1){
            return response()->json([
                'message' => 'You do not have permission to access this resource.'
            ], 401);
        }

        return SoftwareInfo::firstOrFail();
    }

    public function update(Request $request){

        if(auth()->user()->type != 1){
            return response()->json([
                'message' => 'You do not have permission to access this resource.'
            ], 401);
        }

        $info = SoftwareInfo::firstOrFail();
        $info->version = $request->version;
        $info->lastupdate = $request->lastupdate;
        $info->title = $request->title;
        $info->message = $request->message;
        $info->updatelink = $request->updatelink;
        $info->serverlink = $request->serverlink;
        $info->save();
    }

    public function getInfo(){
        return SoftwareInfo::first();
    }
}
