<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\User;
use App\Models\CreditUses;
use Illuminate\Http\Request;

class TransferCreditController extends Controller
{
    public function transfer(Request $request){

        if(auth()->user()->id != 1){

            $user = User::withSum('credit', 'credit')
                ->withSum('credit_uses', 'credit')
                ->find(auth()->user()->id);

            $credit = ($user->credit_sum_credit - $user->credit_uses_sum_credit);

            if($credit < $request->credit){

                return response()->json([
                    'message' => 'No enough credit.',
                    'errors' => [
                        'credit' => ['No enough credit.'],
                    ]
                ], 422);
            }else{

                $credit_uses = new CreditUses();
                $credit_uses->user_id = auth()->user()->id;
                $credit_uses->credit = $request->credit;
                $credit_uses->remark = $request->credit.' credit use for transfer: '.$request->user_id;
                $credit_uses->save();
            
            }
        }

        $credit_transfer = new Credit();
        $credit_transfer->user_id = $request->user_id;
        $credit_transfer->credit = $request->credit;
        $credit_transfer->credit_by = auth()->user()->id;
        $credit_transfer->save();
    }
}
