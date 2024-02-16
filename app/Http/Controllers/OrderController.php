<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\orderRequest;
use App\Http\Resources\orderResource;
use App\order;
use Mail;
use App\User;
use App\product;
use App\payment;
use App\prescription;
use App\shipping;
use App\order_item;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use  Symfony\Component\HttpFoundation\Response;


use App\shop_order_item;
use App\shop_order;
use App\shop_shipping;

class OrderController extends Controller
{


    public function default_address(Request $request){
        DB::table('addresses')->where('user_id', $request->user_id)->update(['is_default' => null]);
        DB::table('addresses')->where('id', $request->id)->update(['is_default' => 'yes']);
          $addresses = DB::table('addresses')
              ->join('delivery_locations', 'delivery_locations.id', '=', 'addresses.location_id')
              ->where('addresses.user_id', $request->user_id)
              ->select('delivery_locations.*','addresses.id as rowid','addresses.username','addresses.address','addresses.contactnumber','is_default')
              ->get();;
        return response()->json($addresses);
    }
    public function delete_paddress(Request $request){

          DB::table('addresses')
            ->where('id', $request->id)
            ->delete();
        $addresses = DB::table('addresses')
            ->join('delivery_locations', 'delivery_locations.id', '=', 'addresses.location_id')
            ->where('addresses.user_id', $request->user_id)
            ->select('delivery_locations.*','addresses.id as rowid','addresses.username','addresses.address','addresses.contactnumber','is_default')
            ->get();
        return response()->json($addresses);
    }
    public function get_paddress(Request $request){

        $addresses =
        DB::table('addresses')
            ->join('delivery_locations', 'delivery_locations.id', '=', 'addresses.location_id')
            ->where('addresses.user_id', $request->user_id)
            ->select('delivery_locations.*','addresses.id as rowid','addresses.username','addresses.address','addresses.contactnumber','is_default')
            ->get();

        return response()->json($addresses);
    }
    public function add_paddress(Request $request){

      $data =   DB::table('addresses')->insertGetId([
            'username' => $request->username,
            'address' => $request->address,
            'contactnumber' => $request->userPhone,
            'cityname' => $request->cityname,
            'location_id' => $request->location,
            'user_id' => $request->user_id,
        ]);
        if($request->default  == true){
              DB::table('addresses')->where('user_id', $request->user_id)->update(['is_default' => null]);
        DB::table('addresses')->where('id', $data)->update(['is_default' => 'yes']);
        }

        $addresses =  DB::table('addresses')
            ->join('delivery_locations', 'delivery_locations.id', '=', 'addresses.location_id')
            ->where('addresses.user_id', $request->user_id)
            ->select('delivery_locations.*','addresses.id as rowid','addresses.username','addresses.address','addresses.contactnumber','is_default')
            ->get();
        return response()->json($addresses);
    }
    public function create_shop_order(Request $request)
    {
        DB::beginTransaction();
        try {
        //request carts  product  data array
        $orders = $request->data;
        $area = $request->area;
        $address = $request->address;
        $customer_id = $request->customer_id;
        $name = $request->name;
        $phone = $request->phone;
        $payment_type = $request->payment_type;
        $delivery_charge = $request->delivery_charge;
        $coupon_discount_amount = $request->discount;
        $sms = $request->sms;

        //products  id list array
        $productID = [];
        foreach ($orders as $order) {
            array_push($productID, $order['product_id']);
        }
        //find  products  info from database
        $products = DB::table('shop_products')->whereIn('id', $productID)
            ->select('shop_products.id', 'shop_products.price', 'shop_products.discount', 'shop_products.buy_price')
            ->get();

        $order_total_amount = 0;
        foreach ($products as $product) {
            $keys = array_keys(array_column($orders, 'product_id'), $product->id);
            $new_array = array_map(function ($k) use ($orders) {
                return $orders[$k];
            }, $keys);
            $cart_quantity = $new_array[0]['cart_quantity'];
            $order_total_amount += ($product->price - $product->discount) * $cart_quantity;
        }


        $data = [
            "order_total" => $order_total_amount,
            "customer_id" => $customer_id,
            "delivery_charge" => $delivery_charge,
            "coupon" => $request->coupon,
            "active_status" => 1,
            "delivery_man_id" => $request->delivery_man_id,
            "coupon_discount_amount" => $coupon_discount_amount,
            "notes" => $request->notes,
            "approve_status" => 1,
            "approve_date" => now(),
            "created_at" => now(),
            "updated_at" => now()
        ];
        // return   $customer_id  ;
        //get  order  id after  insert  order
        $order_id = DB::table('shop_orders')->insertGetId($data);


        $shipping_data = [
            "order_id" => $order_id,
            "name" => $name,
            "phone" => $phone,
            "area" => $area,
            "address" => $address,
            "created_at" => now(),
            "updated_at" => now(),
        ];
        //shipping  data  insert
        $shipping_data = DB::table('shop_shippings')->insertGetId($shipping_data);


        $transaction_number = $order_id . rand(2, 4);

        foreach ($products as $product) {
            $keys = array_keys(array_column($orders, 'product_id'), $product->id);
            $new_array = array_map(function ($k) use ($orders) {
                return $orders[$k];
            }, $keys);
            $cart_quantity = $new_array[0]['cart_quantity'];
            $product_id = $product->id;
            $unit_price = $product->price - $product->discount;
            $order_quantity = $cart_quantity;
            if ($product->buy_price > 0) {
                $buy_price = $product->buy_price;
            } else {
                $buy_price = 0;
            }

            $order_row = new shop_order_item();
            $order_row->order_id = $order_id;
            $order_row->product_id = $product_id;
            $order_row->quantity = $order_quantity;
            $order_row->unit_price = $unit_price;
            $order_row->total_price = $order_quantity * $unit_price;
            $order_row->total_buy_price = $buy_price * $order_quantity;
            $order_row->customer_id = $customer_id;
            $order_row->save();

            //update  stock stock_quantity
            DB::table('shop_products')
                ->where('shop_products.id', '=', $product_id)
                ->decrement('shop_products.stock_quantity', $order_quantity);
        }
        //recheck  order total  amount
        $get_order_total = DB::table('shop_order_items')
            ->where('shop_order_items.order_id', '=', $order_id)
            ->select(DB::raw('sum(total_price) as total_price'))
            ->first();
        $get_order_total = $get_order_total->total_price;
        if ($order_total_amount != $get_order_total) {
            //update  order total recheck
            DB::table('shop_orders')->where('id', $order_id)->update(['order_total' => $get_order_total]);
        }

        DB::table('shop_payments')->insert(
            array('order_id' => $order_id, 'payment_amount' => $get_order_total + $delivery_charge - $coupon_discount_amount, 'payment_type' => $payment_type, 'transaction_number' => $transaction_number, 'customer_id' => $customer_id)
        );

        //fetch  data  for  email
        $userinfo = DB::table('users')
            ->where('users.id', '=', $customer_id)
            ->select('users.name as name')
            ->first();
        $orders = DB::table('shop_orders')
            ->join('shop_order_items', 'shop_order_items.order_id', '=', 'shop_orders.id')
            ->join('shop_products', 'shop_products.id', '=', 'shop_order_items.product_id')
            ->where('shop_orders.id', '=', $order_id)
            ->select('shop_orders.order_total as  order_total', 'shop_orders.delivery_charge as  delivery_charge', 'shop_orders.coupon_discount_amount as  coupon_discount_amount', 'shop_products.name as  product_name', 'shop_products.unit as  unit', 'shop_products.unit_quantity as  unit_quantity', 'shop_order_items.quantity as  quantity', 'shop_order_items.unit_price as  unit_price', 'shop_order_items.total_price as  total_price')
            ->get();

//email settings

        $input = [
            'name' => 'Gopalganj Bazar',
            'email' => 'moniruldiit@gmail.com',
            'orders' => $orders,
            'userinfo' => $userinfo
        ];

        if ($sms == 1) {
            $final_amount = $get_order_total + $delivery_charge - $coupon_discount_amount;
            $url = "http://66.45.237.70/api.php";
            $number = '88' . $request->phone;
            $text = "An Order Has been created at GopalganjBazar.com, Your Order ID:#$order_id.";
            $data = array(
                'username' => 'monircis',
                'password' => 'Monir6789Z',
                'number' => $number,
                'message' => $text
            );

            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $smsresult = curl_exec($ch);
            $p = explode("|", $smsresult);
            $sendstatus = $p[0];
        }

        if ($order_id != null) {
            $get_order_total = DB::table('shop_order_items')
                ->where('shop_order_items.order_id', $order_id)
                ->select(DB::raw('sum(total_price) as get_order_total'))
                ->first();

            DB::table('shop_orders')
                ->where('id', $order_id)
                ->update([
                    'order_total' => $get_order_total->get_order_total
                ]);
                DB::commit();
            return response(
                [
                    'order_id' => $order_id
                ], Response::HTTP_CREATED);
        } else {
                DB::commit();
            return response(
                [
                    'error' => 'something  wrong'
                ]);
        }


        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), $e->getCode());
        }

    }


    public function customer_order_received_status(Request $request)
    {
        $result = DB::table('orders')
            ->where('id', $request->order_id)
            ->update([
                'c_order_received' => now(),
            ]);
        $request->session()->flash('status', 'Customer Received Successfully');
        return redirect()->back();

    }

    public function customize_order_product(Request $request)
    {

        $dd = DB::table('order_items')
            ->where('order_id', $request->order_id)
            ->where('product_id', $request->product_id)
            ->update([
                'quantity' => $request->order_quantity,
                'unit_price' => $request->unit_price,
                'total_price' => $request->total_price,
                'custom_name_en' => $request->custom_name_en,
                'custom_name_bn' => $request->custom_name_bn
            ]);

        $amount = DB::table('orders')
            ->where('id', $request->order_id)
            ->first();
        $plus_amount = $amount->order_total - $request->old_total_price + $request->total_price;

        DB::table('orders')
            ->where('id', $request->order_id)
            ->update([
                'order_total' => $plus_amount
            ]);

        DB::table('payments')
            ->where('order_id', $request->order_id)
            ->update([
                'payment_amount' => $plus_amount + $amount->delivery_charge - $amount->coupon_discount_amount
            ]);

        return response()->json(['success' => $plus_amount]);
    }

    public function admin_custom_order_product_increase($order_id, $product_id, $old_quantity, $new_quantity, $unitPrice)
    {
        DB::beginTransaction();
        try {
            DB::table('order_items')
                ->where('product_id', '=', $product_id)
                ->where('order_id', '=', $order_id)
                ->update(['quantity' => $new_quantity, 'total_price' => $new_quantity * $unitPrice]);

            //update  stock _quantity
            $quantity = $new_quantity - $old_quantity;
            DB::table('products')
                ->where('products.id', '=', $product_id)
                ->decrement('products.stock_quantity', $quantity);


            $get_order_total = DB::table('order_items')
                ->where('order_items.order_id', '=', $order_id)
                ->select(DB::raw('sum(total_price) as total_price'))
                ->first();
            $get_order_total = $get_order_total->total_price;
            DB::table('orders')
                ->where('id', $order_id)
                ->update(['order_total' => $get_order_total]);

            $order_info = DB::table('orders')
                ->where('id', $order_id)
                ->first();

            DB::table('payments')
                ->where('order_id', $order_id)
                ->update([
                    'payment_amount' => $order_info->order_total + $order_info->delivery_charge - $order_info->coupon_discount_amount
                ]);

            DB::commit();
            return response()->json(['message' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), $e->getCode());
        }


    }


    public function admin_custom_order_product_decrease($order_id, $product_id, $old_quantity, $new_quantity, $unitPrice)
    {

        DB::beginTransaction();
        try {
        DB::table('order_items')
            ->where('product_id', '=', $product_id)
            ->where('order_id', '=', $order_id)
            ->update(['quantity' => $new_quantity, 'total_price' => $new_quantity * $unitPrice]);

        //update  stock _quantity
        $quantity = $old_quantity - $new_quantity;
        DB::table('products')
            ->where('products.id', '=', $product_id)
            ->increment('products.stock_quantity', $quantity);

        $get_order_total = DB::table('order_items')
            ->where('order_items.order_id', '=', $order_id)
            ->select(DB::raw('sum(total_price) as total_price'))
            ->first();
        $get_order_total = $get_order_total->total_price;
        DB::table('orders')
            ->where('id', $order_id)
            ->update(['order_total' => $get_order_total]);
        $order_info = DB::table('orders')
            ->where('id', $order_id)
            ->first();

        DB::table('payments')
            ->where('order_id', $order_id)
            ->update([
                'payment_amount' => $order_info->order_total + $order_info->delivery_charge - $order_info->coupon_discount_amount
            ]);
            DB::commit();
        return response()->json(['message' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), $e->getCode());
        }



    }


    public function admin_order(Request $request)
    {
        DB::beginTransaction();
        try {
        //request carts  product  data array
        $orders = $request->data;
        $area = $request->area;
        $area_id = $request->area_id;
        $address = $request->address;
        $customer_id = $request->customer_id;
        $name = $request->name;
        $phone = $request->phone;
        $payment_type = $request->payment_type;
        $delivery_charge = $request->delivery_charge;
        $coupon_discount_amount = $request->discount;
        $sms = $request->sms;
        $delivery_time= $request->delivery_time;

        //products  id list array
        $productID = [];
        foreach ($orders as $order) {
            array_push($productID, $order['product_id']);
        }
        //find  products  info from database
        $products = DB::table('products')->whereIn('id', $productID)
            ->select('products.id', 'products.price', 'products.discount', 'products.buy_price')
            ->get();
        $order_total_amount = 0;
        foreach ($products as $product) {
            $keys = array_keys(array_column($orders, 'product_id'), $product->id);
            $new_array = array_map(function ($k) use ($orders) {
                return $orders[$k];
            }, $keys);
            $cart_quantity = $new_array[0]['cart_quantity'];
            $order_total_amount += ($product->price - $product->discount) * $cart_quantity;
        }

        ///increment coupon used
        DB::table('coupons')
            ->where('coupon_code', $request->coupon)
            ->update([
                'coupon_used' => DB::raw('coupon_used + 1')
            ]);

        $data = [
            "order_total" => $order_total_amount,
            "customer_id" => $customer_id,
            "delivery_charge" => $delivery_charge,
            "coupon" => $request->coupon,
            "active_status" => 1,
            "delivery_man_id" => $request->delivery_man_id,
            "coupon_discount_amount" => $coupon_discount_amount,
            "notes" => $request->notes,
            "approve_status" => 1,
            "approve_date" => now(),
            "created_at" => now(),
            "updated_at" => now()
        ];
        // return   $customer_id  ;
        //get  order  id after  insert  order
        $order_id = DB::table('orders')->insertGetId($data);


        $shipping_data = [
            "order_id" => $order_id,
            "name" => $name,
            "phone" => $phone,
            "area" => $area,
            "area_id" => $area_id,
            "address" => $address,
            "delivery_time" => $delivery_time,
            "created_at" => now(),
            "updated_at" => now(),
        ];
        //shipping  data  insert
        $shipping_data = DB::table('shippings')->insertGetId($shipping_data);


        $transaction_number = $order_id . rand(2, 4);

        foreach ($products as $product) {
            $keys = array_keys(array_column($orders, 'product_id'), $product->id);
            $new_array = array_map(function ($k) use ($orders) {
                return $orders[$k];
            }, $keys);
            $cart_quantity = $new_array[0]['cart_quantity'];
            $product_id = $product->id;
            $unit_price = $product->price - $product->discount;
            $order_quantity = $cart_quantity;
            if ($product->buy_price > 0) {
                $buy_price = $product->buy_price;
            } else {
                $buy_price = 0;
            }

            $order_row = new order_item();
            $order_row->order_id = $order_id;
            $order_row->product_id = $product_id;
            $order_row->quantity = $order_quantity;
            $order_row->unit_price = $unit_price;
            $order_row->total_price = $order_quantity * $unit_price;
            $order_row->total_buy_price = $buy_price * $order_quantity;
            $order_row->customer_id = $customer_id;
            $order_row->save();

            //update  stock stock_quantity
            DB::table('products')
                ->where('products.id', '=', $product_id)
                ->decrement('products.stock_quantity', $order_quantity);
        }
        //recheck  order total  amount
        $get_order_total = DB::table('order_items')
            ->where('order_items.order_id', '=', $order_id)
            ->select(DB::raw('sum(total_price) as total_price'))
            ->first();
        $get_order_total = $get_order_total->total_price;
        if ($order_total_amount != $get_order_total) {
            //update  order total recheck
            DB::table('orders')->where('id', $order_id)->update(['order_total' => $get_order_total]);
        }

        DB::table('payments')->insert(
            array('order_id' => $order_id, 'payment_amount' => $get_order_total + $delivery_charge - $coupon_discount_amount, 'payment_type' => $payment_type, 'transaction_number' => $transaction_number, 'customer_id' => $customer_id)
        );

        //fetch  data  for  email
        $userinfo = DB::table('users')
            ->where('users.id', '=', $customer_id)
            ->select('users.name as name')
            ->first();
        $orders = DB::table('orders')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('orders.id', '=', $order_id)
            ->select('orders.order_total as  order_total', 'orders.delivery_charge as  delivery_charge', 'orders.coupon_discount_amount as  coupon_discount_amount', 'products.name as  product_name', 'products.unit as  unit', 'products.unit_quantity as  unit_quantity', 'order_items.quantity as  quantity', 'order_items.unit_price as  unit_price', 'order_items.total_price as  total_price')
            ->get();

//email settings

        $input = [
            'name' => 'Gopalganj Bazar',
            'email' => 'moniruldiit@gmail.com',
            'orders' => $orders,
            'userinfo' => $userinfo
        ];


//        Mail::send('orders.ordermail',$input, function($mail) use ($input){
//        $mail->from($input['email'],$input['name'])
//        ->to('abirmahadi4@gmail.com','')
//        ->subject('Order Invoice From GopalganjBazar');
//      });

//        Mail::send('orders.ordermail', $input, function ($mail) use ($input) {
//            $mail->from($input['email'], $input['name'])
//                ->to('monirjss@gmail.com', '')
//                ->subject('Order Invoice From GopalganjBazar');
//        });

        if ($sms == 1) {
            $final_amount = $get_order_total + $delivery_charge - $coupon_discount_amount;
            $url = "http://66.45.237.70/api.php";
            $number = '88' . $request->phone;
            $text = "An Order Has been created at GopalganjBazar.com, Your Order ID:#$order_id.";
            $data = array(
                'username' => 'monircis',
                'password' => 'Monir6789Z',
                'number' => $number,
                'message' => $text
            );

            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $smsresult = curl_exec($ch);
            $p = explode("|", $smsresult);
            $sendstatus = $p[0];
        }

        if ($order_id != null) {
            $get_order_total = DB::table('order_items')
                ->where('order_items.order_id', $order_id)
                ->select(DB::raw('sum(total_price) as get_order_total'))
                ->first();

            DB::table('orders')
                ->where('id', $order_id)
                ->update([
                    'order_total' => $get_order_total->get_order_total
                ]);
            DB::commit();
            return response(
                [
                    'order_id' => $order_id
                ], Response::HTTP_CREATED);
        } else {
            DB::commit();
            return response(
                [
                    'error' => 'something  wrong'
                ]);
        }


        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), $e->getCode());
        }



    }

    public function shop_update_shipping($order_id, $address, $customer_name)
    {
        $update = DB::table('shop_shippings')->where('order_id', $order_id)->update(
            [
                'name' => $customer_name,
                'address' => $address
            ]);
        return response()->json([
            'success' => $update
        ]);

    }

    public function shipping_lists($phone)
    {
        $shippings = DB::table('shippings')
            ->where('shippings.phone', '=', $phone)
            ->select('shippings.name', 'shippings.area', 'shippings.address')
            ->orderByDesc('shippings.id')
            ->first();
        return response()->json(['shippings' => $shippings]);
    }

    public function shop_shipping_lists($phone)
    {
        $shippings = DB::table('shop_shippings')
            ->where('shop_shippings.phone', '=', $phone)
            ->select('shop_shippings.name', 'shop_shippings.area', 'shop_shippings.address')
            ->orderByDesc('shop_shippings.id')
            ->first();
        return response()->json(['shippings' => $shippings]);
    }


//    public function __construct()
//    {
//     //$this->middleware('auth:api');
//        ///$this->middleware('auth:api', ['except' => ['single_order']]);
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function admin_custom_order()
    {
        $products = DB::table('products')
            ->get();

        $shippings = DB::table('shippings')
            ->get();
        return view('orders.admin-custom-order', ['shippings' => $shippings, 'products' => $products]);

    }


    public function best_buy_customers()
    {
        $today_date = date('Y-m-d');
        $most_buy_customers = DB::table('orders')
            ->where('orders.delivered_date', '>=', '2020-12-01 00:00:00')
            ->where('orders.delivered_date', '<=', '2020-12-31 23:59:59')
            ->where('orders.active_status', '=', 3)
            ->join('shippings', 'shippings.order_id', '=', 'orders.id')
            ->select('orders.id', 'orders.order_total', 'orders.delivery_charge', 'orders.coupon_discount_amount', 'shippings.phone', 'shippings.name', 'shippings.area', 'shippings.address')
            //->groupBy('shippings.phone')
            ->get();

        $numbers = array();

        foreach ($most_buy_customers as $most_buy) {
            array_push($numbers, $most_buy->phone);
        }
        // dd($numbers);

        $unique_number = array_unique($numbers);

        $users_array = [];
        foreach ($unique_number as $unique_num) {
            array_push($users_array, ['phone' => $unique_num, 'amount' => 0]);
        }


        foreach ($users_array as $key => $val) {

            foreach ($most_buy_customers as $most_buy) {
                if ($most_buy->phone == $users_array[$key]['phone']) {
                    $users_array[$key]['amount'] = $users_array[$key]['amount'] + $most_buy->order_total + $most_buy->delivery_charge - $most_buy->coupon_discount_amount;
                }
            }
        }

        $shinning_customers =
            DB::table('shippings')
                ->get();

        //dd($shinning_customers);

        //$users_array=  collect($users_array);
        return view('orders.best-buy-customers', ['users_array' => $users_array, 'shinning_customers' => $shinning_customers]);
    }


    public function index()
    {
        return order::all();
    }

    public function marketer_user_list()
    {
        $users = DB::table('affiliate_assign_customers')
            ->join('users', 'users.id', '=', 'affiliate_assign_customers.affiliate_user_id')
            ->select('affiliate_assign_customers.customer_phone', 'affiliate_assign_customers.created_at', 'users.*')
            ->get();

        return view('affiliate.list', ['users' => $users]);

    }

    public function marketer_order_activity_admin_view(Request $request)
    {
        $phonelists = DB::table('affiliate_assign_customers')->where('affiliate_user_id', '=', $request->affiliator_id)->select('customer_phone')->get()->toArray();
        $arr = [];
        foreach ($phonelists as $row) {
            $arr[] = (array)$row;
        }
        $orders = DB::table('shippings')
            ->join('orders', 'orders.id', '=', 'shippings.order_id')
            //->where('orders.active_status','=', 1)
            ->whereIn('shippings.phone', $arr)->select('shippings.order_id', 'orders.delivery_charge', 'orders.coupon_discount_amount')->get();
        //dd($orders);

        $order_id_list = [];
        foreach ($orders as $order) {
            $order_id_list[] = (array)$order->order_id;
        }


        $total_sales_amount = 0;
        $total_buy_amount = 0;
        foreach ($order_id_list as $order_id) {
            $get_single_order = DB::table('order_items')
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->where('orders.active_status', '=', 3)
                ->where('order_items.order_id', '=', $order_id)
                //->select('customer_phone')
                ->select(DB::raw('sum(order_items.total_price) as sale_price'), DB::raw('sum(order_items.total_buy_price) as buy_price'))
                ->first();
            $total_sales_amount += $get_single_order->sale_price;
            $total_buy_amount += $get_single_order->buy_price;

//                 dd($get_single_order);

        }
        //return $total_buy_amount;

        $total_discount_amount = 0;
        foreach ($orders as $order) {
            if ($order->coupon_discount_amount > $order->delivery_charge) {
                $discount = $order->coupon_discount_amount - $order->delivery_charge;
                $total_discount_amount += $discount;
            }
        }

        $final_total_buy_amount = $total_discount_amount + $total_buy_amount;
        $sales_profit = ($total_sales_amount - $final_total_buy_amount);
        $affiliate_commission = round(10 * ($sales_profit / 100), 2);

        $affiliator_paid = DB::table('expenses')
            ->where('expenses.type', '=', '13')
            ->where('expenses.affiliate_id', '=', $request->affiliator_id)
            ->sum(DB::raw('amount'));

        $affiliate_commission = $affiliate_commission - $affiliator_paid;

        return response()->json(['affiliate_commission' => $affiliate_commission,'sales' => $total_sales_amount,'profit' => $sales_profit]);

//        $coupon = DB::table('marketers')
//            ->where('marketers.user_id', '=', $id)
//            ->select('marketers.coupon_code as coupon_code')
//            ->first();
//        if ($coupon->coupon_code) {
//            return $orders = DB::table('orders')
//                ->where('orders.coupon', '=', $coupon->coupon_code)
//                ->where('orders.active_status', '=', 3)
//                ->select('orders.order_total as  order_total', 'orders.updated_at as order_date')
//                ->get();
//        }

    }

    public function marketer_order_activity($id)
    {
        $isActive = DB::table('marketers')
            ->where('user_id', '=', $id)
            ->where('status', '=', 1)
            ->count();

        if ($isActive == 1) {
            $phonelists = DB::table('affiliate_assign_customers')->where('affiliate_user_id', '=', $id)->select('customer_phone')->get()->toArray();
            $arr = [];
            foreach ($phonelists as $row) {
                $arr[] = (array)$row;
            }
            $orders = DB::table('shippings')
                ->join('orders', 'orders.id', '=', 'shippings.order_id')
                //->where('orders.active_status','=', 1)
                ->whereIn('shippings.phone', $arr)->select('shippings.order_id', 'orders.delivery_charge', 'orders.coupon_discount_amount')->get();
            //dd($orders);

            $order_id_list = [];
            foreach ($orders as $order) {
                $order_id_list[] = (array)$order->order_id;
            }


            $total_sales_amount = 0;
            $total_buy_amount = 0;
            foreach ($order_id_list as $order_id) {
                $get_single_order = DB::table('order_items')
                    ->join('orders', 'orders.id', '=', 'order_items.order_id')
                    ->where('orders.active_status', '=', 3)
                    ->where('order_items.order_id', '=', $order_id)
                    //->select('customer_phone')
                    ->select(DB::raw('sum(order_items.total_price) as sale_price'), DB::raw('sum(order_items.total_buy_price) as buy_price'))
                    ->first();

//            $get_single_order = DB::table('order_items')
//                ->where('order_id','=', $order_id)
//                //->select('customer_phone')
//                ->select(DB::raw('sum(total_price) as sale_price'),DB::raw('sum(total_buy_price) as buy_price'))
//                ->first();
                $total_sales_amount += $get_single_order->sale_price;
                $total_buy_amount += $get_single_order->buy_price;

//                 dd($get_single_order);

            }
            //return $total_buy_amount;

            $total_discount_amount = 0;
            foreach ($orders as $order) {
                if ($order->coupon_discount_amount > $order->delivery_charge) {
                    $discount = $order->coupon_discount_amount - $order->delivery_charge;
                    $total_discount_amount += $discount;
                }
            }

            $final_total_buy_amount = $total_discount_amount + $total_buy_amount;
            $sales_profit = ($total_sales_amount - $final_total_buy_amount);
            $affiliate_commission = round(10 * ($sales_profit / 100), 2);

            $affiliator_paid = DB::table('expenses')
                ->where('expenses.type', '=', '13')
                ->where('expenses.affiliate_id', '=', $id)
                ->sum(DB::raw('amount'));

            $affiliate_commission = $affiliate_commission - $affiliator_paid;

            return response()->json(['affiliate_commission' => $affiliate_commission]);

//        $coupon = DB::table('marketers')
//            ->where('marketers.user_id', '=', $id)
//            ->select('marketers.coupon_code as coupon_code')
//            ->first();
//        if ($coupon->coupon_code) {
//            return $orders = DB::table('orders')
//                ->where('orders.coupon', '=', $coupon->coupon_code)
//                ->where('orders.active_status', '=', 3)
//                ->select('orders.order_total as  order_total', 'orders.updated_at as order_date')
//                ->get();
//        }
        } else {
            return response()->json(['affiliate_commission' => 0]);
        }

    }


    public function order_activity()
    {
        if (Auth::user()->role != 'vendor') {
            if (Auth::user()->role == 'admin') {
                $roleurl = 'ad/order/';
            } elseif (Auth::user()->role == 'manager') {
                $roleurl = 'pm/order/';
            } elseif (Auth::user()->role == 'author') {
                $roleurl = 'au/order/';
            }
            $home = url('/').'/';
            $orders = DB::table('orders')
                ->select('orders.*')
                ->orderBy('orders.updated_at', 'DESC')->take(13)
                ->get();


            $requests = DB::table('product_requests')
                ->where('product_requests.status', 0)
                ->get();
            $li = '<div>';

            foreach ($requests as $request) {
                if (Auth::user()->role == 'admin') {
                    $li .= '<div class="each-activity request"><a href="http://mmmethod.net/shop/ad/request-list"><i>#' . '</i> A New Product Request  has  been created</span> <br /><i class="fa fa-clock-o"></i> ' . date('h:i A', strtotime($request->updated_at)) . '</a></div>';
                } elseif (Auth::user()->role == 'manager') {
                    $li .= '<div class="each-activity request"><a href="http://mmmethod.net/shop/pm/request-list"><i>#' . '</i> A New Product Request  has  been created</span> <br /><i class="fa fa-clock-o"></i> ' . date('h:i A', strtotime($request->updated_at)) . '</a></div>';
                } elseif (Auth::user()->role == 'author') {
                    $li .= '<div class="each-activity request"><a href="http://mmmethod.net/shop/au/request-list"><i>#' . '</i> A New Product Request  has  been created</span> <br /><i class="fa fa-clock-o"></i> ' . date('h:i A', strtotime($request->updated_at)) . '</a></div>';

                }
            }
            $vendor_requests = DB::table('vendor_requests')
                ->where('vendor_requests.status', 0)
                ->get();

            foreach ($vendor_requests as $vendor_request) {
                if (Auth::user()->role == 'admin') {
                    $li .= '<div class="each-activity request"><a href="http://mmmethod.net/shop/ad/vendor-request"><i>#' . '</i> A New Message  has  been send from vendor/ Customers.</span> <br /><i class="fa fa-clock-o"></i> ' . date('h:i A', strtotime($vendor_request->created_at)) . '</a></div>';
                } elseif (Auth::user()->role == 'manager') {
                    $li .= '<div class="each-activity request"><a href="http://mmmethod.net/shop/pm/vendor-request"><i>#' . '</i>  A New Message  has  been send from vendor/ Customers.</span> <br /><i class="fa fa-clock-o"></i> ' . date('h:i A', strtotime($vendor_request->created_at)) . '</a></div>';
                } elseif (Auth::user()->role == 'author') {
                    $li .= '<div class="each-activity request"><a href="http://mmmethod.net/shop/au/vendor-request"><i>#' . '</i>  A New Message  has  been send from vendor/ Customers.</span> <br /><i class="fa fa-clock-o"></i> ' . date('h:i A', strtotime($vendor_request->created_at)) . '</a></div>';

                }
            }

            $prescriptions = DB::table('prescriptions')
                ->where('prescriptions.status', 0)
                ->get();

            foreach ($prescriptions as $prescription) {
                if (Auth::user()->role == 'admin') {
                    $li .= '<div class="each-activity request"><a href="http://mmmethod.net/shop/ad/prescriptions"><i>#' . '</i> A New Prescription/Bazar List  has  been Uploaded</span> <br /><i class="fa fa-clock-o"></i> ' . date('h:i A', strtotime($prescription->created_at)) . '</a></div>';
                } elseif (Auth::user()->role == 'manager') {
                    $li .= '<div class="each-activity request"><a href="http://mmmethod.net/shop/pm/prescriptions"><i>#' . '</i> A New Prescription/Bazar List  has  been Uploaded</span> <br /><i class="fa fa-clock-o"></i> ' . date('h:i A', strtotime($prescription->created_at)) . '</a></div>';
                } elseif (Auth::user()->role == 'author') {
                    $li .= '<div class="each-activity request"><a href="http://mmmethod.net/shop/au/prescriptions"><i>#' . '</i> A New Prescription/Bazar List  has  been Uploaded</span> <br /><i class="fa fa-clock-o"></i> ' . date('h:i A', strtotime($prescription->created_at)) . '</a></div>';

                }

            }


            foreach ($orders as $order) {

                if ($order->active_status == 0) {

                    $li .= '<div class="each-activity create"> 
      <a href="'.$home . $roleurl . $order->id . '"><span><i>#' . $order->id . '</i> A New Order has  been created</span> <br /><i class="fa fa-clock-o"></i> ' . date('h:i A', strtotime($order->updated_at)) . '</a></div>';
                } elseif ($order->active_status == 1) {
                    $li .= '<div class="each-activity approve"><a href="'.$home . $roleurl . $order->id . '"><span><i>#' . $order->id . '</i> Order has  been Approved</span> <br /><i class="fa fa-clock-o"></i> ' . date('h:i A', strtotime($order->updated_at)) . '</a></div>';
                } elseif ($order->active_status == 2) {
                    $li .= '<div class="each-activity transit"><a href="'.$home . $roleurl . $order->id . '"><span><i>#' . $order->id . '</i> Order is In Transit</span> <br /><i class="fa fa-clock-o"></i> ' . date('h:i A', strtotime($order->updated_at)) . '</a></div>';
                } elseif ($order->active_status == 3) {
                    $li .= '<div class="each-activity done"><a href="'.$home . $roleurl . $order->id . '"><span><i>#' . $order->id . '</i> Order has  been Delivered successfully</span> <br /><i class="fa fa-clock-o"></i> ' . date('h:i A', strtotime($order->updated_at)) . '</a></div>';
                } elseif ($order->active_status == 4) {
                    $li .= '<div class="each-activity cancel"><a href="'.$home . $roleurl . $order->id . '"><span><i>#' . $order->id . '</i> Order has  been Cancelled</span> <br /><i class="fa fa-clock-o"></i> ' . date('h:i A', strtotime($order->updated_at)) . '</a></div>';
                }

            }
            $li .= '</div>';

            return response()->json(['success' => $li]);


            //return response()->json(['success'=>$orders

            //return response()->json(array('msg'=> $orders), 200);

        }


    }


    public function low_stock()
    {

        $products = DB::table('products')
            ->where('products.status', '<=', 1)
            ->where('products.stock_quantity', '<=', 5)
            ->where('products.buy_price', '>', 0)
            ->orderBy('products.stock_quantity')
            ->get();

        $li = '';
        foreach ($products as $product) {
            $li .= '<tr><td>' . $product->name . ' ' . $product->unit_quantity . $product->unit . '</td><td>' . $product->stock_quantity . '</td></tr>';
        }
        $li .= '';

        return response()->json(['success' => $li]);


        //return response()->json(['success'=>$orders

        //return response()->json(array('msg'=> $orders), 200);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //public function create()
    //{
    //
    //}

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
//    public function store(orderRequest $request)
//    {
//
//        DB::beginTransaction();
//        try {
//        if ($request->customer_id) {
//            $user_id = $request->customer_id;
//        } else {
//            //New Customer Order
//            $user = User::create([
//                'name' => $request->name,
//                'phone' => $request->phone,
//                'password' => Hash::make($request->password),
//                'role' => '3',
//                'area' => $request->area,
//                'address' => $request->address
//            ]);
//            $user_id = $user->id;
//        }
//
//        $area = $request->area;
//
//        $whatIWant = trim(str_before($area, '+'));
//
//        $loc = DB::table('delivery_locations')
//            ->where('delivery_locations.id', '=', $whatIWant)->get();
//        $area_name = $loc[0]->location_name;
//
//        //ODER Table Data
//
//        $customer_id = $user_id;
//        $name = $request->name;
//        $area = $request->area;
//        $phone = $request->phone;
//        $payment_type = $request->payment_type;
//        $delivery_charge = $request->delivery_charge;
//
//        //request orders  info
//        $orders = $request->data;
//
//        //products  id list array
//        $productID = [];
//        foreach ($orders as $order) {
//            array_push($productID, $order['product_id']);
//        }
//        //find  products  info from database
//        $products = DB::table('products')
//            ->where('status', '=', 1)
//            ->where('stock_quantity', '>', 0)
//            ->whereIn('id', $productID)
//            ->select('products.id', 'products.price', 'products.discount', 'products.buy_price')
//            ->get();
//        $order_total_amount = 0;
//        foreach ($products as $product) {
//            $keys = array_keys(array_column($orders, 'product_id'), $product->id);
//            $new_array = array_map(function ($k) use ($orders) {
//                return $orders[$k];
//            }, $keys);
//            $cart_quantity = $new_array[0]['cart_quantity'];
//
//            $order_total_amount += ($product->price - $product->discount) * $cart_quantity;
//        }
//
//
//        if (strlen($request->coupon) > 0) {
//            $coupon = strtoupper($request->coupon);
//
//            $coupon_amount = DB::table('coupons')
//                ->whereDate('coupons.active_from', '<=', now())
//                ->whereDate('coupons.active_until', '>=', now())
//                ->where('coupons.coupon_code', '=', $coupon)
//                ->where('coupons.status', '=', 0)
//                ->first();
//
//            // DB::table('coupons')
//            //->where('coupon_code', $coupon)->first();
//
//            if ($coupon_amount === null) {
//                $coupon_discount_amount = 0;
//            } else {
////                if (strtoupper($coupon_amount->coupon_discount) === 'FREE') {
////
////                    $coupon_discount_amount = $request->delivery_charge;
////                } else {
//                //}
//
//                $get_location = DB::table('delivery_locations')
//                    ->where('delivery_locations.id', '=', $whatIWant)
//                    ->first();
//                if ($order_total_amount >= $get_location->min_order_amount) {
//                    $coupon_discount_amount = $request->delivery_charge;
//                } else {
//                    $coupon_discount_amount = 0;
//                }
//            }
//
//            ///increment coupon used
//            DB::table('coupons')
//                ->where('coupon_code', $request->coupon)
//                ->update([
//                    'coupon_used' => DB::raw('coupon_used + 1')
//                ]);
//
//
//        } else {
//            $coupon = 0;
//            $coupon_discount_amount = 0;
//        }
//
//
//        $shipping_address = $request->shipping_address;
//
//        $data = [
//            "order_total" => $order_total_amount,
//            "customer_id" => $customer_id,
//            "delivery_charge" => $delivery_charge,
//            "coupon" => $coupon,
//            "active_status" => 0,
//            "coupon_discount_amount" => $coupon_discount_amount,
//            "created_at" => now(),
//            "updated_at" => now()
//        ];
//        // return   $customer_id  ;
//        //get  order  id
//        $order_id = DB::table('orders')->insertGetId($data);
//
//        $shipping_data = [
//            "order_id" => $order_id,
//            "name" => $name,
//            "phone" => $phone,
//            "area" => $area_name,
//            "area_id" => $whatIWant,
//            "address" => $shipping_address,
//            "created_at" => now(),
//            "updated_at" => now(),
//        ];
//        //shipping  data  insert
//        $shipping_data = DB::table('shippings')->insertGetId($shipping_data);
//
//        if ($request->transaction_number) {
//            $transaction_number = $request->transaction_number;
//        } else {
//            $transaction_number = $order_id . rand(2, 4);
//        }
//
//
//        foreach ($products as $product) {
//
//            $keys = array_keys(array_column($orders, 'product_id'), $product->id);
//            $new_array = array_map(function ($k) use ($orders) {
//                return $orders[$k];
//            }, $keys);
//            $cart_quantity = $new_array[0]['cart_quantity'];
//
//            $product_id = $product->id;
//            $unit_price = $product->price - $product->discount;
//            $order_quantity = $cart_quantity;
//            if ($product->buy_price > 0) {
//                $buy_price = $product->buy_price;
//            } else {
//                $buy_price = 0;
//            }
//
//            $order_row = new order_item();
//            $order_row->order_id = $order_id;
//            $order_row->product_id = $product_id;
//            $order_row->quantity = $order_quantity;
//            $order_row->unit_price = $unit_price;
//            $order_row->total_price = $order_quantity * $unit_price;
//            $order_row->total_buy_price = $buy_price * $order_quantity;
//            $order_row->customer_id = $customer_id;
//            $order_row->save();
//
//            //update  stockstock_quantity
//            DB::table('products')
//                ->where('products.id', '=', $product_id)
//                ->decrement('products.stock_quantity', $order_quantity);
//
//        }
//
//        $get_order_total = DB::table('order_items')
//            ->where('order_items.order_id', '=', $order_id)
//            ->select(DB::raw('sum(total_price) as total_price'))
//            ->first();
//        $get_order_total = $get_order_total->total_price;
//        if ($order_total_amount != $get_order_total) {
//
//            //update  order total recheck
//            DB::table('orders')->where('id', $order_id)->update(['order_total' => $get_order_total]);
//        }
//
//        DB::table('payments')->insert(
//            array('order_id' => $order_id, 'payment_amount' => $get_order_total + $delivery_charge - $coupon_discount_amount, 'payment_type' => $payment_type, 'transaction_number' => $transaction_number, 'customer_id' => $customer_id)
//        );
//
//
//        $userinfo = DB::table('users')
//            ->where('users.id', '=', $user_id)
//            ->select('users.name as name')
//            ->first();
//
//        $orders = DB::table('orders')
//            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
//            ->join('products', 'products.id', '=', 'order_items.product_id')
//            ->where('orders.id', '=', $order_id)
//            ->select('orders.order_total as  order_total', 'orders.delivery_charge as  delivery_charge', 'orders.coupon_discount_amount as  coupon_discount_amount', 'products.name as  product_name', 'products.unit as  unit', 'products.unit_quantity as  unit_quantity', 'order_items.quantity as  quantity', 'order_items.unit_price as  unit_price', 'order_items.total_price as  total_price')
//            ->get();
//
////        $input = [
////            'name' => 'Gopalganj Bazar',
////            'email' => 'info@gopalganjbazar.com',
////            'orders' => $orders,
////            'userinfo' => $userinfo
////        ];
//
//
////        Mail::send('orders.ordermail',$input, function($mail) use ($input){
////        $mail->from($input['email'],$input['name'])
////        ->to('abirmahadi4@gmail.com','')
////        ->subject('Order Invoice From GopalganjBazar');
////      });
////        Mail::send('orders.ordermail', $input, function ($mail) use ($input) {
////            $mail->from($input['email'], $input['name'])
////                ->to('monirjss@gmail.com', '')
////                ->subject('Order Invoice From GopalganjBazar');
////        });
//
//        $final_amount = $get_order_total + $delivery_charge - $coupon_discount_amount;
//        $url = "http://66.45.237.70/api.php";
//        $number = '88' . $request->phone;
//        // $text="Thanks  for  your Order. Order ID: $order_id . Order Amount: $final_amount Tk. You will get Confirmation soon.";
//        $text = "An Order Has been created at GopalganjBazar.com, Your Order ID:#$order_id. You will get Confirmation soon.";
//        $data = array(
//            'username' => 'monircis',
//            'password' => 'Monir6789Z',
//            'number' => $number,
//            'message' => $text
//        );
//
//        $ch = curl_init(); // Initialize cURL
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        $smsresult = curl_exec($ch);
//        $p = explode("|", $smsresult);
//        $sendstatus = $p[0];
//            DB::commit();
//        return response(
//            [
//                'data' => $request->all()
//            ], Response::HTTP_CREATED);
//
//        } catch (\Exception $e) {
//            DB::rollback();
//            return response()->json($e->getMessage(), $e->getCode());
//        }
//    }




//        $input = [
//            'name' => 'Gopalganj Bazar',
//            'email' => 'info@gopalganjbazar.com',
//            'orders' => $orders,
//            'userinfo' => $userinfo
//        ];


//        Mail::send('orders.ordermail',$input, function($mail) use ($input){
//        $mail->from($input['email'],$input['name'])
//        ->to('abirmahadi4@gmail.com','')
//        ->subject('Order Invoice From GopalganjBazar');
//      });
//        Mail::send('orders.ordermail', $input, function ($mail) use ($input) {
//            $mail->from($input['email'], $input['name'])
//                ->to('monirjss@gmail.com', '')
//                ->subject('Order Invoice From GopalganjBazar');
//        });


    public function store_test(orderRequest $request)
    {

        DB::beginTransaction();
        try {
            if ($request->customer_id) {
                $user_id = $request->customer_id;
            } else {
                //New Customer Order
                $user = User::create([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                    'role' => '3',
                    'area' => $request->area,
                    'address' => $request->address
                ]);
                $user_id = $user->id;
            }

            $area = $request->area;
            if($request->area_id){
                $loc = DB::table('delivery_locations')
                    ->where('delivery_locations.id', '=', $request->area_id)->first();
                $area_name = $loc->location_name;
                $whatIWant = $request->area_id;
            }else{
                $whatIWant = trim(str_before($area, '+'));
                $loc = DB::table('delivery_locations')
                    ->where('delivery_locations.id', '=', $whatIWant)->first();
                $area_name = $loc->location_name;
            }


            //ODER Table Data

            $customer_id = $user_id;
            $name = $request->name;
            $area = $request->area;
            $phone = $request->phone;
            $payment_type = $request->payment_type;
            $delivery_charge = $request->delivery_charge;

            //request orders  info
            $orders = $request->data;

            //products  id list array
            $productID = [];
            foreach ($orders as $order) {
                array_push($productID, $order['product_id']);
            }
            //find  products  info from database
            $products = DB::table('products')
                ->where('status', '=', 1)
                ->where('stock_quantity', '>', 0)
                ->whereIn('id', $productID)
                ->select('products.id', 'products.price', 'products.discount', 'products.buy_price')
                ->get();
            $order_total_amount = 0;
            foreach ($products as $product) {
                $keys = array_keys(array_column($orders, 'product_id'), $product->id);
                $new_array = array_map(function ($k) use ($orders) {
                    return $orders[$k];
                }, $keys);
                $cart_quantity = $new_array[0]['cart_quantity'];

                $order_total_amount += ($product->price - $product->discount) * $cart_quantity;
            }


            if (strlen($request->coupon) > 0) {
                $coupon = strtoupper($request->coupon);

                $coupon_amount = DB::table('coupons')
                    ->whereDate('coupons.active_from', '<=', now())
                    ->whereDate('coupons.active_until', '>=', now())
                    ->where('coupons.coupon_code', '=', $coupon)
                    ->where('coupons.status', '=', 0)
                    ->first();


                if ($coupon_amount === null) {
                    $coupon_discount_amount = 0;
                } else if (strpos($coupon_amount->coupon_discount, "%") !== false) {
                    $coupon_discount = $coupon_amount->coupon_discount;
                    $order_amount = $delivery_charge + $order_total_amount;
                    $coupon_discount = ($order_amount * str_replace("%", "", $coupon_discount)) / 100;
                    $coupon_discount_amount = (int)$coupon_discount;

                } else {
                    $get_location = DB::table('delivery_locations')
                        ->where('delivery_locations.id', '=', $whatIWant)
                        ->first();
                    if ($order_total_amount >= $get_location->min_order_amount) {
                        $coupon_discount_amount = $coupon_amount->coupon_discount;
                    } else {
                        $coupon_discount_amount = 0;
                    }
                }

                ///increment coupon used
                DB::table('coupons')
                    ->where('coupon_code', $request->coupon)
                    ->update([
                        'coupon_used' => DB::raw('coupon_used + 1')
                    ]);


            } else {
                $coupon = 0;
                $coupon_discount_amount = 0;
            }


            $shipping_address = $request->shipping_address;

            $data = [
                "order_total" => $order_total_amount,
                "customer_id" => $customer_id,
                "delivery_charge" => $delivery_charge,
                "coupon" => $coupon,
                "active_status" => 0,
                "coupon_discount_amount" => $coupon_discount_amount,
                "created_at" => now(),
                "updated_at" => now()
            ];
            // return   $customer_id  ;
            //get  order  id
            $order_id = DB::table('orders')->insertGetId($data);

            $shipping_data = [
                "order_id" => $order_id,
                "name" => $name,
                "phone" => $phone,
                "area" => $area_name,
                "area_id" => $request->area_id,
                "address" => $shipping_address,
                "delivery_time" => $request->delivery_time,
                "created_at" => now(),
                "updated_at" => now(),
            ];
            //shipping  data  insert
            $shipping_data = DB::table('shippings')->insertGetId($shipping_data);

            if ($request->transaction_number) {
                $transaction_number = $request->transaction_number;
            } else {
                $transaction_number = $order_id . rand(2, 4);
            }


            foreach ($products as $product) {

                $keys = array_keys(array_column($orders, 'product_id'), $product->id);
                $new_array = array_map(function ($k) use ($orders) {
                    return $orders[$k];
                }, $keys);
                $cart_quantity = $new_array[0]['cart_quantity'];

                $product_id = $product->id;
                $unit_price = $product->price - $product->discount;
                $order_quantity = $cart_quantity;
                if ($product->buy_price > 0) {
                    $buy_price = $product->buy_price;
                } else {
                    $buy_price = 0;
                }

                $order_row = new order_item();
                $order_row->order_id = $order_id;
                $order_row->product_id = $product_id;
                $order_row->quantity = $order_quantity;
                $order_row->unit_price = $unit_price;
                $order_row->total_price = $order_quantity * $unit_price;
                $order_row->total_buy_price = $buy_price * $order_quantity;
                $order_row->customer_id = $customer_id;
                $order_row->save();

                //update  stockstock_quantity
                DB::table('products')
                    ->where('products.id', '=', $product_id)
                    ->decrement('products.stock_quantity', $order_quantity);

            }

            $get_order_total = DB::table('order_items')
                ->where('order_items.order_id', '=', $order_id)
                ->select(DB::raw('sum(total_price) as total_price'))
                ->first();
            $get_order_total = $get_order_total->total_price;
            if ($order_total_amount != $get_order_total) {

                //update  order total recheck
                DB::table('orders')->where('id', $order_id)->update(['order_total' => $get_order_total]);
            }

            DB::table('payments')->insert(
                array('order_id' => $order_id, 'payment_amount' => $get_order_total + $delivery_charge - $coupon_discount_amount, 'payment_type' => $payment_type, 'transaction_number' => $transaction_number, 'customer_id' => $customer_id)
            );


            $userinfo = DB::table('users')
                ->where('users.id', '=', $user_id)
                ->select('users.name as name')
                ->first();

            $orders = DB::table('orders')
                ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->join('products', 'products.id', '=', 'order_items.product_id')
                ->where('orders.id', '=', $order_id)
                ->select('orders.order_total as  order_total', 'orders.delivery_charge as  delivery_charge', 'orders.coupon_discount_amount as  coupon_discount_amount', 'products.name as  product_name', 'products.unit as  unit', 'products.unit_quantity as  unit_quantity', 'order_items.quantity as  quantity', 'order_items.unit_price as  unit_price', 'order_items.total_price as  total_price')
                ->get();

//        $input = [
//            'name' => 'Gopalganj Bazar',
//            'email' => 'info@gopalganjbazar.com',
//            'orders' => $orders,
//            'userinfo' => $userinfo
//        ];


//        Mail::send('orders.ordermail',$input, function($mail) use ($input){
//        $mail->from($input['email'],$input['name'])
//        ->to('abirmahadi4@gmail.com','')
//        ->subject('Order Invoice From GopalganjBazar');
//      });
//        Mail::send('orders.ordermail', $input, function ($mail) use ($input) {
//            $mail->from($input['email'], $input['name'])
//                ->to('monirjss@gmail.com', '')
//                ->subject('Order Invoice From GopalganjBazar');
//        });

        $final_amount = $get_order_total + $delivery_charge - $coupon_discount_amount;
        $url = "http://66.45.237.70/api.php";
        $number = '88' . $request->phone;
        // $text="Thanks  for  your Order. Order ID: $order_id . Order Amount: $final_amount Tk. You will get Confirmation soon.";
       if($request->delivery_time){
           $text = "An Order Has been created at GopalganjBazar.com, Your Order ID:#$order_id. Expected delivery time is between $request->delivery_time.  You will get Confirmation soon.";
       }else{
           $text = "An Order Has been created at GopalganjBazar.com, Your Order ID:#$order_id. You will get Confirmation soon.";
       }
         $data = array(
            'username' => 'monircis',
           'password' => 'Monir6789Z',
            'number' => $number,
            'message' => $text
        );

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        $p = explode("|", $smsresult);
//        $sendstatus = $p[0];
            DB::commit();
            return response(
                [
                    'data' => $request->all()
                ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function store(orderRequest $request)
    {

        DB::beginTransaction();
        try {
            if ($request->customer_id) {
                $user_id = $request->customer_id;
            } else {
                //New Customer Order
                $user = User::create([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                    'role' => '3',
                    'area' => $request->area,
                    'address' => $request->address
                ]);
                $user_id = $user->id;
            }

            $area = $request->area;
            if($request->area_id){
                $loc = DB::table('delivery_locations')
                    ->where('delivery_locations.id', '=', $request->area_id)->first();
                $area_name = $loc->location_name;
                $whatIWant = $request->area_id;
            }else{
                $whatIWant = trim(str_before($area, '+'));
                $loc = DB::table('delivery_locations')
                    ->where('delivery_locations.id', '=', $whatIWant)->first();
                $area_name = $loc->location_name;
            }


            //ODER Table Data

            $customer_id = $user_id;
            $name = $request->name;
            $area = $request->area;
            $phone = $request->phone;
            $payment_type = $request->payment_type;
            $delivery_charge = $request->delivery_charge;

            //request orders  info
            $orders = $request->data;

            //products  id list array
            $productID = [];
            foreach ($orders as $order) {
                array_push($productID, $order['product_id']);
            }
            //find  products  info from database
            $products = DB::table('products')
                ->where('status', '=', 1)
                ->where('stock_quantity', '>', 0)
                ->whereIn('id', $productID)
                ->select('products.id', 'products.price', 'products.discount', 'products.buy_price')
                ->get();
            $order_total_amount = 0;
            foreach ($products as $product) {
                $keys = array_keys(array_column($orders, 'product_id'), $product->id);
                $new_array = array_map(function ($k) use ($orders) {
                    return $orders[$k];
                }, $keys);
                $cart_quantity = $new_array[0]['cart_quantity'];

                $order_total_amount += ($product->price - $product->discount) * $cart_quantity;
            }


            if (strlen($request->coupon) > 0) {
                $coupon = strtoupper($request->coupon);

                $coupon_amount = DB::table('coupons')
                    ->whereDate('coupons.active_from', '<=', now())
                    ->whereDate('coupons.active_until', '>=', now())
                    ->where('coupons.coupon_code', '=', $coupon)
                    ->where('coupons.status', '=', 0)
                    ->first();


                if ($coupon_amount === null) {
                    $coupon_discount_amount = 0;
                } else if (strpos($coupon_amount->coupon_discount, "%") !== false) {
                    $coupon_discount = $coupon_amount->coupon_discount;
                    $order_amount = $delivery_charge + $order_total_amount;
                    $coupon_discount = ($order_amount * str_replace("%", "", $coupon_discount)) / 100;
                    $coupon_discount_amount = (int)$coupon_discount;

                } else {
                    $get_location = DB::table('delivery_locations')
                        ->where('delivery_locations.id', '=', $whatIWant)
                        ->first();
                    if ($order_total_amount >= $get_location->min_order_amount) {
                        $coupon_discount_amount = $request->delivery_charge;
                    } else {
                        $coupon_discount_amount = 0;
                    }
                }

                ///increment coupon used
                DB::table('coupons')
                    ->where('coupon_code', $request->coupon)
                    ->update([
                        'coupon_used' => DB::raw('coupon_used + 1')
                    ]);


            } else {
                $coupon = 0;
                $coupon_discount_amount = 0;
            }


            $shipping_address = $request->shipping_address;

            $data = [
                "order_total" => $order_total_amount,
                "customer_id" => $customer_id,
                "delivery_charge" => $delivery_charge,
                "coupon" => $coupon,
                "active_status" => 0,
                "coupon_discount_amount" => $coupon_discount_amount,
                "created_at" => now(),
                "updated_at" => now()
            ];
            // return   $customer_id  ;
            //get  order  id
            $order_id = DB::table('orders')->insertGetId($data);

            $shipping_data = [
                "order_id" => $order_id,
                "name" => $name,
                "phone" => $phone,
                "area" => $area_name,
                "area_id" => $request->area_id,
                "address" => $shipping_address,
                "created_at" => now(),
                "updated_at" => now(),
            ];
            //shipping  data  insert
            $shipping_data = DB::table('shippings')->insertGetId($shipping_data);

            if ($request->transaction_number) {
                $transaction_number = $request->transaction_number;
            } else {
                $transaction_number = $order_id . rand(2, 4);
            }


            foreach ($products as $product) {

                $keys = array_keys(array_column($orders, 'product_id'), $product->id);
                $new_array = array_map(function ($k) use ($orders) {
                    return $orders[$k];
                }, $keys);
                $cart_quantity = $new_array[0]['cart_quantity'];

                $product_id = $product->id;
                $unit_price = $product->price - $product->discount;
                $order_quantity = $cart_quantity;
                if ($product->buy_price > 0) {
                    $buy_price = $product->buy_price;
                } else {
                    $buy_price = 0;
                }

                $order_row = new order_item();
                $order_row->order_id = $order_id;
                $order_row->product_id = $product_id;
                $order_row->quantity = $order_quantity;
                $order_row->unit_price = $unit_price;
                $order_row->total_price = $order_quantity * $unit_price;
                $order_row->total_buy_price = $buy_price * $order_quantity;
                $order_row->customer_id = $customer_id;
                $order_row->save();

                //update  stockstock_quantity
                DB::table('products')
                    ->where('products.id', '=', $product_id)
                    ->decrement('products.stock_quantity', $order_quantity);

            }

            $get_order_total = DB::table('order_items')
                ->where('order_items.order_id', '=', $order_id)
                ->select(DB::raw('sum(total_price) as total_price'))
                ->first();
            $get_order_total = $get_order_total->total_price;
            if ($order_total_amount != $get_order_total) {

                //update  order total recheck
                DB::table('orders')->where('id', $order_id)->update(['order_total' => $get_order_total]);
            }

            DB::table('payments')->insert(
                array('order_id' => $order_id, 'payment_amount' => $get_order_total + $delivery_charge - $coupon_discount_amount, 'payment_type' => $payment_type, 'transaction_number' => $transaction_number, 'customer_id' => $customer_id)
            );


            $userinfo = DB::table('users')
                ->where('users.id', '=', $user_id)
                ->select('users.name as name')
                ->first();

            $orders = DB::table('orders')
                ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->join('products', 'products.id', '=', 'order_items.product_id')
                ->where('orders.id', '=', $order_id)
                ->select('orders.order_total as  order_total', 'orders.delivery_charge as  delivery_charge', 'orders.coupon_discount_amount as  coupon_discount_amount', 'products.name as  product_name', 'products.unit as  unit', 'products.unit_quantity as  unit_quantity', 'order_items.quantity as  quantity', 'order_items.unit_price as  unit_price', 'order_items.total_price as  total_price')
                ->get();

            $final_amount = $get_order_total + $delivery_charge - $coupon_discount_amount;
            $url = "http://66.45.237.70/api.php";
            $number = '88' . $request->phone;
            // $text="Thanks  for  your Order. Order ID: $order_id . Order Amount: $final_amount Tk. You will get Confirmation soon.";
            $text = "An Order Has been created at GopalganjBazar.com, Your Order ID:#$order_id. You will get Confirmation soon.";
            $data = array(
            'username' => 'monircis',
            'password' => 'Monir6789Z',
            'number' => $number,
            'message' => $text
            );

            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $smsresult = curl_exec($ch);
            $p = explode("|", $smsresult);
//        $sendstatus = $p[0];
            DB::commit();
            return response(
                [
                    'data' => $request->all()
                ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), $e->getCode());
        }
    }


    public function vendor_order_list()
    {
        $userId = Auth::id();
        $orders = DB::table('products')
            ->join('order_items', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('products.user_id', $userId)
            ->select('products.*', 'order_items.quantity as order_quantity', 'order_items.unit_price as unit_price', 'order_items.total_price as total_price', 'orders.created_at as order_date', 'orders.active_status as active_status')
            ->get();
        //  dd($orders);
        return view('vendor.orders.index', ['orders' => $orders]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(order $order)
    {
        //
    }
}
