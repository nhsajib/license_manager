<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\CreditUses;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SupperSellerController extends Controller
{
    public function index(){
        return User::withSum('credit', 'credit')
            ->withSum('credit_uses', 'credit')
            ->where('type', 2)
            ->orderBy('id', 'desc')
            ->paginate(20);
    }

    public function store(Request $request){

        if(auth()->user()->type != 1){
            return response()->json([
                'message' => 'You do not have permission to access this resource.'
            ], 401);
        }

        $request->validate([
            'name' => 'required|string|max:52',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'status' => 'required',
        ]);
        
        $super_seller = new User();
        $super_seller->name = $request->name;
        $super_seller->email = $request->email;
        $super_seller->password = Hash::make($request->password);
        $super_seller->type = 2;
        $super_seller->createdby = auth()->user()->id;
        $super_seller->createdate = Carbon::now();
        $super_seller->status = $request->status;
        $super_seller->save();

        if(!empty($request->credit)){

            $credit = new Credit();
            $credit->user_id = $super_seller->id;
            $credit->credit = $request->credit;
            $credit->credit_by = auth::user()->id;
            $credit->save();

        }else{

            $credit = new Credit();
            $credit->user_id = $super_seller->id;
            $credit->credit = 0;
            $credit->credit_by = auth::user()->id;
            $credit->save();
        
        }

        $credit_uses = new CreditUses();
        $credit_uses->user_id = $super_seller->id;
        $credit_uses->credit = 0;
        $credit_uses->remark = 'Credit used init';
        $credit_uses->save();
    }

    public function update(Request $request){

        $request->validate([
            'name' => 'required|string|max:52',
            'email' => 'required|email|unique:users,email,'.$request->id,
            // 'password' => 'required',
            'status' => 'required',
        ]);



        $super_seller = User::find($request->id);
        $super_seller->name = $request->name;
        $super_seller->email = $request->email;
        if(isset($request->password)){
            $super_seller->password = Hash::make($request->password);
        }
        $super_seller->status = $request->status;
        $super_seller->save();

    }

    public function destroy($id){
        return User::find($id)->delete();
    }
}
