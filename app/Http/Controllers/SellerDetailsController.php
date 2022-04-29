<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\User;
use Illuminate\Http\Request;

class SellerDetailsController extends Controller
{
    public function sellersBySupSellerId($id){

        if(auth()->user()->type != 1){
            return response()->json([
                'message' => 'You do not have permission to access this resource.'
            ], 401);
        }

        return User::withSum('credit', 'credit')
        ->withSum('credit_uses', 'credit')
        ->where('type', 3)
        ->where('createdby', $id)
        ->orderBy('id', 'desc')
        ->paginate(20);
    }

    public function licenseBySupSeller($id){

        $seller = User::findOrFail($id);
        
        if( ($seller->createdby == auth()->user()->id) || auth()->user()->type == 1 ){
            return License::where('createbyid', $id)->paginate(20);
        }else{
            return response()->json([
                'message' => 'You do not have permission to access this resource.'
            ]);
        }
    }
}
