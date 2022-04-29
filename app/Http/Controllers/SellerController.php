<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\CreditUses;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SellerController extends Controller
{
    public function index(){

        if(auth()->user()->type == 1){

            return User::withSum('credit', 'credit')
            ->withSum('credit_uses', 'credit')
            ->where('type', 3)
            ->orderBy('id', 'desc')
            ->paginate(20);

        }else{

            return User::withSum('credit', 'credit')
            ->withSum('credit_uses', 'credit')
            ->where('type', 3)
            ->where('createdby', auth()->user()->id)
            ->orderBy('id', 'desc')
            ->paginate(20);

        }

    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required|string|max:52',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'status' => 'required',
        ]);

        if(auth()->user()->id != 1){

            $user = User::withSum('credit', 'credit')
                ->withSum('credit_uses', 'credit')
                ->find(auth()->user()->id);

            $credit = ($user->credit_sum_credit - $user->credit_uses_sum_credit);

            if($request->credit > $credit){

                return response()->json([
                    'status' => 'faild',
                    'message' => 'No enough credit',
                ], 422);

            }else{

                $credit_uses = new CreditUses();
                $credit_uses->user_id = auth()->user()->id;
                $credit_uses->credit = !empty($request->credit) ? $request->credit : 0;
                $credit_uses->remark = $request->credit.' credit use for create_seller: '.$request->name;
                $credit_uses->save();
            }
        }

        $super_seller = new User();
        $super_seller->name = $request->name;
        $super_seller->email = $request->email;
        $super_seller->password = Hash::make($request->password);
        $super_seller->type = 3;
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

        return response()->json([
            'status' => 'success',
            'message' => 'Create successful',
        ]);

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
