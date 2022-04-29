<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CreditUses;
use App\Models\License;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    public function index(){

        if(auth()->user()->type != 1){
            return License::where('createbyid', auth()->user()->id)->orderBy('id', 'desc')->paginate(20);
        }else{
            return License::orderBy('id', 'desc')->paginate(20);
        }


    }

    public function store(Request $request){

        $request->validate([
            'keyid' => 'required|unique:licenses,keyid',
            'username' => 'required|max:32'
        ]);


        if(auth()->user()->id != 1){

            $user = User::withSum('credit', 'credit')
                ->withSum('credit_uses', 'credit')
                ->find(auth()->user()->id);

            $credit = ($user->credit_sum_credit - $user->credit_uses_sum_credit);

            if($credit > 0){

                if($request->type != 'demo'){
                    $credit_uses = new CreditUses();
                    $credit_uses->user_id = auth()->user()->id;
                    $credit_uses->credit = 1;
                    $credit_uses->remark = '1 credit use for create_license: '.$request->username;
                    $credit_uses->save();
                }

            }else{

                return response()->json([
                    'status' => 'faild',
                    'message' => 'No enough credit',
                ], 422);

            }
        }

        $license = new License();
        $license->keyid = $request->keyid;
        $license->username = $request->username;
        $license->create_date = Carbon::now();
        if($request->type == 'demo'){
            $license->expire_date = Carbon::now()->addDays(2);
        }else{
            $license->expire_date = Carbon::now()->addDays(33);

        }
        $license->createdby = auth()->user()->name;
        $license->createbyid = auth()->user()->id;
        $license->status = 1;
        $license->save();

    }

    public function active($id){
        $lics = License::find($id);
        $lics->status = 1;
        $lics->save();
    }

    public function deactive($id){
        $lics = License::find($id);
        $lics->status = 0;
        $lics->save();
    }

    public function renewId($id){

        if(auth()->user()->id != 1){

            $user = User::withSum('credit', 'credit')
                ->withSum('credit_uses', 'credit')
                ->find(auth()->user()->id);

            $credit = ($user->credit_sum_credit - $user->credit_uses_sum_credit);

            if($credit > 0){
                $credit_uses = new CreditUses();
                $credit_uses->user_id = auth()->user()->id;
                $credit_uses->credit = 1;
                $credit_uses->remark = '1 credit use for renew_license: '.$id;
                $credit_uses->save();
            }else{
                return response()->json([
                    'status' => 'faild',
                    'message' => 'No enough credit',
                ], 422);
            }

            $license = License::find($id);
            $license->expire_date = Carbon::parse($license->expire_date)->addDays(33);
            $license->save();
        }
    }

    public function destroy($id){
        return License::find($id)->delete();
    }
}
