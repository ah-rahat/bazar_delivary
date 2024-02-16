<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\user;
use Auth;
use Illuminate\Support\Facades\DB;

class depositController extends Controller
{
    public function  add_reference(Request $request){
        $count=DB::table('shippings')
            ->where('shippings.phone', '=',$request->phone)
            ->count();
        if($count == 0){
            $count=DB::table('customer_references')
                ->where('customer_references.referer_phone', '=',$request->phone)
                ->count();
            if($count == 1){
                return response()->json([
                    'message' => 'This Customer is Already joined with us.',
                ]);
            }else{
                  DB::table('customer_references')->insert(
                    [
                        'user_id' => $request->user_id,
                        'referer_phone' => $request->phone,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]
                );
                return response()->json([
                    'message' => 'Thanks for add new customer, Convince him to make order more than 499 taka.',
                ]);
            }

        }else{
            return response()->json([
                'message' => 'This Customer is Already joined with us.',
            ]);
        }
    }

    public function  deposit_refer_list($user_id){
        $customers=DB::table('customer_references')
            ->where('customer_references.user_id', '=',$user_id)
            ->get();


        return response()->json([
            'customers' => $customers
        ]);
    }

    public function  deposit_message(){

        $data=DB::table('deposit_message')
            ->where('deposit_message.id', '=',1)
            ->first();

        return response()->json([
            'data' => $data
        ]);
    }

    public function remaining_deposit_amount(){
        $users = DB::table('users')
            ->get();
        $customers_deposits=DB::table('deposits')
            ->select(DB::raw("SUM(amount) as total_deposits"),"customer_phone")
            ->groupBy('customer_phone')
            ->get();
        $customers_purchase=DB::table('due_purchase_history')
            ->select(DB::raw("SUM(amount) as amount"),"customer_phone")
            ->groupBy('customer_phone')
            ->get();

        return view('deposit.remaining-deposit-list', ['customers_deposits' => $customers_deposits, 'customers_purchase' => $customers_purchase, 'users' => $users]);

    }


    public function deposit_checked($id){
        $result= DB::table('deposit_requests')->where('id', $id)->update(
            [
                'status' =>1
            ]
        );
        if($result ==true){
            return redirect()->back();
        }

    }

    public function deposit_request_list()
    {
        $customers = User::all();

        $deposits = DB::table('deposit_requests')
            ->orderBy('id', 'DESC')
            ->get();

        return view('deposit.deposit-request', [
            'customers' => $customers,
            'deposits' => $deposits,
        ]);

    }

    public function deposit_request(Request $request)
    {
        $insert = DB::table('deposit_requests')->insert(
            [
                'customer_id' => $request->customer_id,
                'payment_method' => $request->payment_method,
                'phone' => $request->number,
                'transaction_id' => $request->transaction_id,
                'amount' => $request->amount,
                'requestMessage' => $request->requestMessage,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
        if($insert == true){
            return response()->json([
                'status' => 1
            ]);
        }else{
            return response()->json([
                'status' => 0
            ]);
        }
    }



    public function purchase_from_deposit_money(Request $request){

        $result= DB::table('payments')->where('order_id', $request->order_id)->update(
            [
                'payment_type' =>4
            ]
        );

            $insert = DB::table('due_purchase_history')->insert(
                [
                    'customer_phone' => $request->phone,
                    'order_id' => $request->order_id,
                    'amount' => $request->order_total,
                    'order_date' => Carbon::now(),
                    'added_by' => Auth::id(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            );

            if($insert ==true){
                $request->session()->flash('status', ' Payment Take from Deposit Money');
                return redirect()->back();
            }
    }


    public function deposit_history($id)
    {
        $user = DB::table('users')
            ->where('users.id','=', $id)
            ->first();

        $deposits=DB::table('deposits')
            ->where('deposits.customer_phone', '=',$user->phone)
            ->select(DB::raw('sum(amount) as total_amount'))
            ->first();
        $deposit_history=DB::table('deposits')
            ->where('deposits.customer_phone', '=',$user->phone)
            ->orderBy('id', 'DESC')
            ->get();
        $purchase_deposit_amount=DB::table('due_purchase_history')
            ->where('due_purchase_history.customer_phone', '=',$user->phone)
            ->select(DB::raw('sum(amount) as amount'))
            ->first();


        return response()->json([
            'deposit_total' => $deposits->total_amount - $purchase_deposit_amount->amount,
            'deposit_history' => $deposit_history,
            'promotion' => ''
        ]);

    }


    public function index()
    {
       $customers = User::all();

        $deposits = DB::table('deposits')
            ->orderBy('id', 'DESC')
                 ->get();

        return view('deposit.index', [
            'customers' => $customers,
            'deposits' => $deposits,
        ]);
    }

    public function save_deposit(Request $request)
    {
        $insert = DB::table('deposits')->insert(
            [
                'customer_phone' => $request->customer_phone,
                'amount' => $request->deposit_amount,
                'payment_method' => $request->payment_method,
                'added_by' => Auth::id(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
         if($insert == true){
             $request->session()->flash('success', 'Deposit Added Successfully');
             return redirect()->back();
         }else{
             $request->session()->flash('error', 'Something Error');
             return redirect()->back();
         }
    }
}