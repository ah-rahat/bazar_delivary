<?php

namespace App\Http\Controllers;
use App\Category;
use App\attendance;
use App\Http\Resources\category\CategoryResource;
use App\Http\Resources\category\categoryProductResource;
use App\sub_category;
use App\child_sub_cats;
use App\delivery_location;
use App\prescription;
use Illuminate\Http\Request;
use App\offer_image;

use Auth;
use  Illuminate\Support\Facades\Redirect;
//for  upload image  use this  one
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class AdminController extends Controller
{

    public function apply_job(Request $request){

        $values = array(
            'full_name' => $request->full_name,
            'phone'=> $request->phone,
            'email'=> $request->email,
            'job_type'=> $request->job_type,
            'job_time'=> $request->job_time,
            'education'=> $request->education,
            'vehicle' => $request->vehicle,
            'created_at' =>  Carbon::now());
        $res=DB::table('job_candidates')->insert($values);
        return response()->json([
            'data' => $res
        ]);
    }
    public function refered_customers(){

        $customer_references = DB::table('customer_references')
            ->get();
        $customers = DB::table('users')
            ->get();
        return view('refered-customer', [
            'customer_references' => $customer_references,
            'customers' => $customers
        ]);
    }



    public function select_sms(Request $request){
        $affected = DB::table('temp_sms_histories')
            ->update(['text' => $request->message]);
        return response()->json([
            'message' => $affected
        ]);
    }


    public function temp_sms_history(){

        $users = DB::table('temp_sms_histories')
            ->join('sms', 'sms.id', '=', 'temp_sms_histories.text')
            ->select('temp_sms_histories.phone','sms.text')
            ->get();


        return view('temp-sms-list', [
            'users' => $users
        ]);

    }
    public function assign_number($phone,$status){

        if($status == 'true'){
            $values = array('phone' =>  $phone,'status'=>1 ,'text'=>0,'created_at' =>  Carbon::now(), 'send_by' => Auth::id());
            $res=DB::table('temp_sms_histories')->insert($values);
        }
        if($status == 'false'){
            $res=DB::table('temp_sms_histories')->where('phone', $phone)->delete();
        }


        return response()->json([
            'message' => $res
        ]);
    }

    public function save_sms(Request $request){

        $values = array('text' =>  $request->message,'created_at' =>  Carbon::now(), 'user_id' => Auth::id());
        $res=DB::table('sms')->insert($values);
        $request->session()->flash('status', 'SMS Added Successfully.');
        return redirect()->back();
    }


    public function sms_history(){
        $users = DB::table('shippings')
            ->select('phone','name','area','address')
            ->groupBy('phone')
            ->get();
        return view('sms-history', [
            'users' => $users,
        ]);
    }

    public function sms(){

        $users = DB::table('shippings')
            ->select('phone','name','area','address')
            ->groupBy('phone')
            ->get();
        //dd($users);
       $message = DB::table('sms')
           ->get();

        return view('sms', [
            'users' => $users,
            'messages' => $message,
        ]);
    }


    public function product_expires_list()
    {
        $products = DB::table('products')
            ->where('products.real_stock', '=',1)
            ->where('products.stock_quantity', '>',0)
            //->select('products.id','products.stock_quantity')
            ->get();

        $data = [];

        foreach ($products as $product){
            $list = DB::table('product_stocks')
                ->where('product_stocks.product_id', '=',$product->id)
                ->join('products', 'products.id', '=', 'product_stocks.product_id')
                ->orderBy('product_stocks.id', 'DESC')
                ->select('product_stocks.product_id','product_stocks.quantity','product_stocks.quantity','product_stocks.price','product_stocks.expire_date',
                    'product_stocks.old_stock','products.name','products.name_bn','products.unit','products.unit_quantity')
                ->limit(2)
                ->get();
            //dd($list);
            foreach ($list as $single){
                if($product->stock_quantity <= $single->quantity){

                    $date = Carbon::parse($single->expire_date);
                    $now = Carbon::now();
                    $diff = $date->diffInDays($now);

                    array_push($data,
                        array(
                            "product_remaining_quantity"=> $product->stock_quantity,
                            "product_id"=> $single->product_id,
                            "quantity"=> $single->quantity,
                            "price"=> $single->price,
                            "expire_date"=> $single->expire_date,
                            "old_stock"=> $single->old_stock,
                            "name"=> $single->name,
                            "name_bn"=> $single->name_bn,
                            "unit"=> $single->unit,
                            "unit_quantity"=> $single->unit_quantity,
                            "days" => $diff
                        )
                    );
                }
                break;
            }
        }

        $expires = [];
        foreach ($data as $dt){

            if($dt['days'] < 30){
                array_push($expires,
                    array(
                        "product_remaining_quantity"=> $dt['product_remaining_quantity'],
                        "product_id"=> $dt['product_id'],
                        "quantity"=> $dt['quantity'],
                        "price"=> $dt['price'],
                        "expire_date"=> date('d M Y', strtotime($dt['expire_date'])),
                        "old_stock"=> $dt['old_stock'],
                        "name"=> $dt['name'],
                        "name_bn"=> $dt['name_bn'],
                        "unit"=> $dt['unit'],
                        "unit_quantity"=> $dt['unit_quantity'],
                        "days" => $dt['days']
                    )
                );
            }
        }

        return response()->json([
            'data' => $expires
        ]);

    }

    public function expire_products_show(){
        return view('products.expires-list');

    }
    public function shop_expire_products()
    {
        $products = DB::table('shop_products')
            ->where('shop_products.real_stock', '=',1)
            ->where('shop_products.stock_quantity', '>',0)
            //->select('products.id','products.stock_quantity')
            ->get();

        $data = [];

        foreach ($products as $product){
            $list = DB::table('shop_product_stocks')
                ->where('shop_product_stocks.product_id', '=',$product->id)
                ->join('shop_products', 'shop_products.id', '=', 'shop_product_stocks.product_id')
                ->orderBy('shop_product_stocks.id', 'DESC')
                ->select('shop_product_stocks.product_id','shop_product_stocks.quantity','shop_product_stocks.quantity',
                    'shop_product_stocks.price','shop_product_stocks.expire_date',
                    'shop_product_stocks.old_stock','shop_products.name','shop_products.name_bn','shop_products.unit','shop_products.unit_quantity')
                ->limit(2)
                ->get();
            //dd($list);
            foreach ($list as $single){
                if($product->stock_quantity <= $single->quantity){

                    $date = Carbon::parse($single->expire_date);
                    $now = Carbon::now();
                    $diff = $date->diffInDays($now);

                    array_push($data,
                        array(
                            "product_remaining_quantity"=> $product->stock_quantity,
                            "product_id"=> $single->product_id,
                            "quantity"=> $single->quantity,
                            "price"=> $single->price,
                            "expire_date"=> $single->expire_date,
                            "old_stock"=> $single->old_stock,
                            "name"=> $single->name,
                            "name_bn"=> $single->name_bn,
                            "unit"=> $single->unit,
                            "unit_quantity"=> $single->unit_quantity,
                            "days" => $diff
                        )
                    );
                }
                break;
            }
        }

        $expires = [];
        foreach ($data as $dt){
            // strtotime($dt['expire_date'])
            $date_now = date("Y-m-d"); // this format is string comparable

            if($date_now > $dt['expire_date']){
                array_push($expires,
                    array(
                        "product_remaining_quantity"=> $dt['product_remaining_quantity'],
                        "product_id"=> $dt['product_id'],
                        "quantity"=> $dt['quantity'],
                        "price"=> $dt['price'],
                        "expire_date"=> date('d M Y', strtotime($dt['expire_date'])),
                        "old_stock"=> $dt['old_stock'],
                        "name"=> $dt['name'],
                        "name_bn"=> $dt['name_bn'],
                        "unit"=> $dt['unit'],
                        "unit_quantity"=> $dt['unit_quantity'],
                        "days" => $dt['days']
                    )
                );
            }
        }

        return response()->json([
            'data' => $expires
        ]);

    }

    public function expire_products()
    {
        $products = DB::table('products')
            ->where('products.real_stock', '=',1)
            ->where('products.stock_quantity', '>',0)
            //->select('products.id','products.stock_quantity')
            ->get();

        $data = [];

        foreach ($products as $product){
            $list = DB::table('product_stocks')
                ->where('product_stocks.product_id', '=',$product->id)
                ->join('products', 'products.id', '=', 'product_stocks.product_id')
                ->orderBy('product_stocks.id', 'DESC')
                ->select('product_stocks.product_id','product_stocks.quantity','product_stocks.quantity','product_stocks.price','product_stocks.expire_date',
                    'product_stocks.old_stock','products.name','products.name_bn','products.unit','products.unit_quantity')
                ->limit(2)
                ->get();
            //dd($list);
            foreach ($list as $single){
                if($product->stock_quantity <= $single->quantity){

                    $date = Carbon::parse($single->expire_date);
                    $now = Carbon::now();
                    $diff = $date->diffInDays($now);

                    array_push($data,
                        array(
                            "product_remaining_quantity"=> $product->stock_quantity,
                            "product_id"=> $single->product_id,
                            "quantity"=> $single->quantity,
                            "price"=> $single->price,
                            "expire_date"=> $single->expire_date,
                            "old_stock"=> $single->old_stock,
                            "name"=> $single->name,
                            "name_bn"=> $single->name_bn,
                            "unit"=> $single->unit,
                            "unit_quantity"=> $single->unit_quantity,
                            "days" => $diff
                        )
                    );
                }
                break;
            }
        }

        $expires = [];
        foreach ($data as $dt){
           // strtotime($dt['expire_date'])
                $date_now = date("Y-m-d"); // this format is string comparable

            if($date_now > $dt['expire_date']){
                array_push($expires,
                    array(
                        "product_remaining_quantity"=> $dt['product_remaining_quantity'],
                        "product_id"=> $dt['product_id'],
                        "quantity"=> $dt['quantity'],
                        "price"=> $dt['price'],
                        "expire_date"=> date('d M Y', strtotime($dt['expire_date'])),
                        "old_stock"=> $dt['old_stock'],
                        "name"=> $dt['name'],
                        "name_bn"=> $dt['name_bn'],
                        "unit"=> $dt['unit'],
                        "unit_quantity"=> $dt['unit_quantity'],
                        "days" => $dt['days']
                    )
                );
            }
        }

        return response()->json([
            'data' => $expires
        ]);

    }

    public function expired_date()
    {
        $products = DB::table('products')
            ->where('products.real_stock', '=',1)
            //->select('products.id','products.stock_quantity')
            ->get();

        $data = [];

        foreach ($products as $product){
            $list = DB::table('product_stocks')
                ->where('product_stocks.product_id', '=',$product->id)
                ->orderBy('product_stocks.id', 'DESC')
                ->limit(2)
                ->get();
            //dd($list);
            foreach ($list as $single){
                if($product->stock_quantity <= $single->quantity){

                    $date = Carbon::parse($single->expire_date);
                    $now = Carbon::now();
                    $diff = $date->diffInDays($now);

                    array_push($data,
                        array(
                            "id"=> $single->id,
                            "product_id"=> $single->product_id,
                            "quantity"=> $single->quantity,
                            "price"=> $single->price,
                            "expire_date"=> $single->expire_date,
                            "old_stock"=> $single->old_stock,
                            "user_id"=> $single->user_id,
                            "created_at"=> $single->created_at,
                            "days" => $diff
                        )
                    );
                }
                break;
            }
        }
       // dd(collect($data));

        return view('products.expired-date',['data'=> collect($data)]);

    }




    public function trash()
    {
         $trashes = DB::table('trashes')->get();
        return view('trash.index',['trashes'=>$trashes]);
    }

    public function save_trash(Request $request)
    {
        $result =  DB::table('trashes')->insert([
            'name' => $request->name,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'date' => date("Y-m-d", strtotime($request->date)),
            'created_at' => Carbon::now()
        ]);
        if($result == 1){
            $request->session()->flash('status', 'Trash Added Successfully.');
            return redirect()->back();
        }
    }

    public function manage_stock_money()
    {
        $stock_money = DB::table('stock_money')->orderBy('id', 'desc')
->get();
        return view('stock-money.index',['stockMonies'=>$stock_money]);
    }

    public function save_stock_manage(Request $request)
    {
        $result =  DB::table('stock_money')->insert([
            'amount' => $request->amount,
            'type' => $request->type,
            'purpose' => $request->purpose,
            'date' => date("Y-m-d", strtotime($request->date)),
            'user_id' => Auth::id(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        if($result == 1){
            $request->session()->flash('status', ' Added Successfully.');
            return redirect()->back();
        }
    }



  public function index()
  {
      $investments = DB::table('investments')->get();
      $invest = DB::table('investments')
          ->select(DB::raw('sum(amount) as amount'))
          ->first();

      return view('investment.add-invest',['investments'=>$investments,'invest'=>$invest]);

  }

    public function save_invest(Request $request)
    {
       $result =  DB::table('investments')->insert([
            'investor' => $request->investor,
            'amount' => $request->amount,
            'date' => date("Y-m-d", strtotime($request->date)),
            'user_id' => Auth::id(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
       if($result == 1){
           $request->session()->flash('status', ' Investment added Successfully.');
           return redirect()->back();
       }

    }



}


