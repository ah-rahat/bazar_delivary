<?php
namespace App\Http\Controllers;
use App\Http\Resources\order\orderResource;
use Illuminate\Http\Request;
use App\order;
use App\payment;
use App\order_item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class myOrderController extends Controller
{

    public function delivery_mans()
    {

        $mans=DB::table('delivery_mans')
            ->where('delivery_mans.status', '=',1)
            ->get();
        return response()->json([
            'delivery_mans' => $mans
        ]);
    }


    public function receive_due_payment(Request $request){
        $values = array(
            'pay_amount' => $request->amount,
            'due_customer_id' => $request->customer_id,
            'user_id' => $request->user_id,
            "created_at" =>  date('Y-m-d H:i:s'),
            "updated_at" =>  date('Y-m-d H:i:s')
        );
        $res=DB::table('collect_due_payment')->insert($values);
              return response()->json([
                  'message' => $res
              ]);
    }


    public function save_due_payment(Request $request){
        $values = array(
            'order_id' => $request->order_id,
            'amount' => $request->amount,
            'order_date' => $request->order_date,
            'customer_id' => $request->customer_id,
            'user_id' => $request->user_id,
            "created_at" =>  date('Y-m-d H:i:s'),
            "updated_at" =>  date('Y-m-d H:i:s')
        );
        $res=DB::table('due_sales')->insert($values);
        return response()->json([
            'message' => $res
        ]);
    }


    public function admin_single_order($id)
    {
        $get_single_order = DB::table('orders')
            ->join('shippings', 'orders.id', '=', 'shippings.order_id')
            ->where('orders.id','=', $id)
            ->first();
        return response()->json([
            'get_single_order' => $get_single_order
        ]);

    }



     public function customer_orders_show($id)
          {

           $todayDate= date("Y-m-d");
            $get_user_id = $id;
            $orders = DB::table('orders')
             ->join('payments', 'payments.order_id', '=', 'orders.id')
            //->join('shippings', 'orders.id', '=', 'shippings.order_id')
          ->select('orders.*', 'payments.payment_type', 'payments.transaction_number')
          ->whereDate('orders.created_at', Carbon::today())
           ->orderBy('orders.id', 'DESC')
          ->get();
           $shipping = DB::table('orders')
             //->join('payments', 'orders.id', '=', 'payments.order_id')
            ->join('shippings', 'orders.id', '=', 'shippings.order_id')
          ->select('orders.id as order_id','shippings.address', 'shippings.area', 'shippings.phone')
          ->whereDate('orders.created_at', Carbon::today())
           ->orderBy('orders.id', 'DESC')
          ->get();
           return response()->json([
           'orders'=>$orders,
           'shipings'=>$shipping
           ]);
           //return $orders;
          //return new orderResource($orders);

    }
    
     public function customer_order_items($id)
          {
         
            $get_user_id = $id;
            
           $order_items = DB::table('order_items')
            ->join('products', 'products.id', '=', 'order_items.product_id') 
            ->select('order_items.*', 'products.name','products.name_bn','products.unit','products.unit_quantity')
           //->whereRaw('Date(order_items.created_at) = CURDATE()')
           ->whereDate('order_items.created_at', Carbon::today()) 
            ->get(); 
         //return $order_items;
        
          return new orderResource($order_items);
            
    }
    
     public  function  cancel_order(Request $request){

         DB::beginTransaction();
         try {
         $order_id= $request->this_order_id;

         $order=DB::table('orders')
             ->where('id', $order_id)
             ->first();

         if($order->active_status==1 || $order->active_status==3 || $order->active_status==4){
             return 'error';
         }else{
             $result=   DB::table('orders')->where('id', $order_id)->update(
                 [
                     'cancel_status' =>1,
                     'active_status' =>4,
                     'cancel_date' => now(),
                     'updated_at' => now(),
                     'user_id'=>$request->user_id,
                 ]
             );

             if($result==1){

                 //fetch all  ordered  products
                 $order_items=DB::table('order_items')
                     ->join('products', 'products.id', '=', 'order_items.product_id')
                     ->select('order_items.product_id','order_items.quantity as  order_quantity','products.stock_quantity as avaiable_stock')
                     ->where('order_items.order_id', '=', $order_id)
                     ->get();

                 foreach($order_items as $item){
                     //return $new_quantity=$item->avaiable_stock-$item->order_quantity. '-' . $item->product_id;
                     $new_quantity=$item->avaiable_stock+$item->order_quantity;

                     DB::table('products')
                         ->where('id', $item->product_id)
                         ->update(['stock_quantity' => $new_quantity]);

                 }
                 DB::commit();
                 return response()->json([
                     'message' => "Order Cancel Successfully.",
                     'status' => '1',
                 ]);


             }
         }
     } catch (\Exception $e) {
DB::rollback();
return response()->json($e->getMessage(), $e->getCode());
}
     }
    
    
    public  function  single_order_detail($user_id,$id){
        $orders=DB::table('orders')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->join('shippings', 'orders.id', '=', 'shippings.order_id')
            ->select('orders.*', 'payments.payment_type','payments.transaction_number', 'shippings.address')
           ->where('orders.customer_id', '=', $user_id)
            ->where('orders.id', '=', $id)
            ->get();
        //return $orders;
         return new orderResource($orders);
    }

    public  function  deposit_order_show($id){
        $get_user_id =$id;


        $orders=DB::table('orders')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->join('shippings', 'orders.id', '=', 'shippings.order_id')
            ->select('orders.*', 'payments.payment_type','payments.transaction_number', 'shippings.address','shippings.area','shippings.phone')
            ->where('orders.customer_id', '=', $get_user_id)
            ->where('payments.payment_type', '=', 4)
            //->groupBy('orders')
            // ->groupBy('orders.id')
            ->orderBy('orders.id', 'DESC')
            ->take(100)
            ->get();

        //return $orders;
        return new orderResource($orders);
    }

    public  function  show($id){
        $get_user_id =$id;
        //$orders =   order::where('customer_id', $get_user_id)->orderBy('id', 'DESC')->get();
        //$orders = DB::select( DB::raw("SELECT orders.*,payments.payment_type,payments.transaction_number,shippings.address,shippings.area,shippings.phone FROM orders INNER JOIN shippings ON orders.id = shippings.order_id INNER JOIN payments ON payments.order_id=orders.id WHERE orders.customer_id='$get_user_id' GROUP BY orders.id ") );        
         
//           $orders_data=DB::table('orders')
//          ->join('payments', 'orders.id', '=', 'payments.order_id')
//         ->join('shippings', 'orders.id', '=', 'shippings.order_id')
//        ->select('orders.*', 'payments.payment_type','payments.transaction_number', 'shippings.address','shippings.area','shippings.phone')
//        ->where('orders.customer_id', '=', $get_user_id)
//        ->get();
      //$orders = $orders_data->groupBy('id'); 
      
        $orders=DB::table('orders')
          ->join('payments', 'orders.id', '=', 'payments.order_id')
         ->join('shippings', 'orders.id', '=', 'shippings.order_id')
        ->select('orders.*', 'payments.payment_type','payments.transaction_number', 'shippings.address','shippings.area','shippings.phone','shippings.delivery_time')
        ->where('orders.customer_id', '=', $get_user_id)
        //->groupBy('orders')
        // ->groupBy('orders.id')
         ->orderBy('orders.id', 'DESC')
            ->take(100)
        ->get();    
         
        //return $orders;
         return new orderResource($orders);
    }
    

      public  function  deposit_order_items($id){
        $get_user_id =$id;
        $order_items = DB::table('order_items')
            ->join('products', 'products.id', '=', 'order_items.product_id') 
           ->where('order_items.customer_id', '=', $get_user_id)
            ->select('order_items.*', 'products.name','products.name_bn')
           ->orderBy('order_items.order_id', 'DESC')
            ->get(); 
         //return $order_items;
         return new orderResource($order_items);
    }
    public  function  order_items($id){
        $get_user_id =$id;
        $order_items = DB::table('order_items')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('order_items.customer_id', '=', $get_user_id)
            ->select('order_items.*', 'products.name','products.name_bn')
            ->orderBy('order_items.order_id', 'DESC')
            ->get();
        //return $order_items;
        return new orderResource($order_items);
    }

    
}
