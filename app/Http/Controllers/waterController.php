<?php

namespace App\Http\Controllers;

use App\User;
use App\otptoken;
use App\marketer;
use App\water;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use phpDocumentor\Reflection\Types\Object_;
use Tymon\JWTAuth\Exceptions\JWTException;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Auth;

class waterController extends Controller
{

    public function test_for_qury()
    {


//Update a product list  using  by category id
//        $data = DB::table('products')
//
//            ->where('sub_category_id', '=', 284)
//
//            ->get();
//
//        foreach ($data as $data){
//
//            if($data->price >100){
//                $percentage = 5;
//                $totalWidth = $data->price;
//                $discount = floor(($percentage / 100) * $totalWidth);
//                echo $update =  DB::table('products')
//                    ->where('id', $data->id)
//                    ->update(['discount' => $discount]);
//
//            }else{
//                echo  $data->id;
//            }
//
//        }

        //dd($data);
        exit();
        //////////////////////////////////////////
        /// calculate  a single  product  sales  order  id
        ///
        $new_startDate = '2021-10-07 00:00:00';
        $new_endDate = '2021-10-22 23:59:59';

        $sales_data = DB::table('orders')
            ->selectRaw("orders.id as id")
            ->where('delivered_date', '>=', $new_startDate)
            ->where('delivered_date', '<=', $new_endDate)
            ->where('active_status', '=', 3)
            ->get();

        //dd($sales_data);
        $data = [];
        foreach ($sales_data as $sale){
            $sales = DB::table('order_items')
                ->where('order_items.product_id', '=',6349 )
                ->where('order_items.order_id', '=',$sale->id )
                ->selectRaw("order_items.order_id as order_id")
                ->first();
            if($sales){
            array_push($data,$sales);
            }
        }

dd($data);
        //////////////////////////////////////////
        /// END calculate  a single  product  sales  order  id
        /// /////////////////////////////

        $today = date('Y-m-d');
        $sales_summary = DB::table('order_items')
                  ->where('order_items.product_id', '=',  37435)
                  ->where('order_items.created_at', '>=',  '2021-09-01  00:00:00')
                  ->where('order_items.created_at', '<=', '2021-09-30 23:59:59')
            ->select(DB::raw('sum(total_buy_price) as total_buy_price'), DB::raw('sum(total_price) as total_price'))
            ->first();
dd($sales_summary);
        $products = DB::table('products')
            ->where('products.real_stock', '=',1)
            ->select('products.id','products.stock_quantity')
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
                    array_push($data,$single);
                }
                break;
            }
        }


  return view('products.expired-date',['data'=>$data,'products'=>$products]);

    }



    public function water_receipt(){

        $orders = DB::table('orders')
            ->join('shippings', 'shippings.order_id', '=', 'orders.id')
            ->leftJoin('delivery_locations', 'delivery_locations.id', '=', 'shippings.area_id')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->where('order_items.product_id', 37435)
            ->whereIn('orders.active_status', [0,1,2])
            ->select('shippings.*','delivery_locations.water_location_serial')
            ->orderBy('delivery_locations.water_location_serial', 'DESC')
            ->get();

        return view('water.water-receipt',['orders'=>$orders]);
    }

    public function water_today_orders(){

        $orders = DB::table('orders')
            ->join('shippings', 'shippings.order_id', '=', 'orders.id')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->where('order_items.product_id', 37435)
            ->whereIn('orders.active_status', [0,1,2])
            ->select('orders.*','shippings.*','order_items.product_id','order_items.order_id')
            ->orderBy('orders.id', 'DESC')
            ->get();
 
        return view('orders.water-orders',['orders'=>$orders]);
    }


    public function due_customers_index(){
        $due_customers=DB::table('due_customers')
            ->where('status', 1)
            ->get();

        $total_dues = DB::table('due_sales')
            ->sum(DB::raw('amount'));
        $total_paid = DB::table('collect_due_payment')
            ->sum(DB::raw('pay_amount'));

        return view('due_customers.due-customer',['due_customers'=>$due_customers,'total_dues'=> $total_dues,'total_paid'=> $total_paid]);

    }

    public function add_due_customer(Request $request){
        $values = array(
            'name' => $request->name,
            'phone' => $request->phone,
            "created_at" =>  date('Y-m-d H:i:s'),
            "updated_at" =>  date('Y-m-d H:i:s')
        );
        $res=DB::table('due_customers')->insert($values);
        $request->session()->flash('status', ' Due Customer added successfully!');
        return redirect()->back();
    }


    public function customers_due($id){
        $due_customer=DB::table('due_customers')
            ->where('id', $id)
            ->first();

        $dues = DB::table('due_sales')
            ->where('customer_id', $id)
            ->orderBy('id', 'DESC')
            ->get();
        $payments = DB::table('collect_due_payment')
            ->where('due_customer_id', $id)
            ->orderBy('id', 'DESC')
            ->get();

        $total_dues = DB::table('due_sales')
            ->where('customer_id', $id)
            ->sum(DB::raw('amount'));
        $total_paid = DB::table('collect_due_payment')
            ->where('due_customer_id', $id)
            ->sum(DB::raw('pay_amount'));


        return view('due_customers.customer-due-list',['due_customer'=>$due_customer,'total_dues'=>$total_dues,'total_paid'=>$total_paid,'dues'=>$dues,'payments'=>$payments]);
    }


        public function water_customer_comment($phone, $comment){

        $update =  DB::table('water_customers')
            ->where('phone', $phone)
            ->update(['comment' => $comment]);
        return  response()->json('ok');
    }


    //damage
    public function damage_stock_list(){
        $res=DB::table('damages')
            ->join('products', 'products.id', '=', 'damages.product_id')
            ->where('damages.is_deleted', '=', 0)
            ->select('damages.id','damages.created_at','products.name','products.unit','products.unit_quantity','products.unit','damages.quantity','damages.total_price')
            ->get();

        $total=DB::table('damages')
            ->where('is_deleted', '=', 0)
            ->sum(DB::raw('total_price'));

        return view('products.damage-stock-list',['products'=>$res,'total'=>$total]);

    }


    public function save_damage_list($id,$quantity,$total_price)
    {
        $values = array(
            'product_id' => $id,
            'quantity' => $quantity,
            'total_price' => $total_price,
            "created_at" =>  date('Y-m-d H:i:s'),
            "updated_at" =>  null
        );
        $res=DB::table('damages')->insert($values);

        return  response()->json($res);

    }



    public function del_damage_list($id){

        DB::table('damages')->where('id', $id)->update(
            [
                'is_deleted' => 1,
                "updated_at" =>  date('Y-m-d H:i:s'),
            ]);

        return redirect()->back();
    }


    //damage

    public function waiting_stock_list(){
        $res=DB::table('waiting_stocks')
            ->join('products', 'products.id', '=', 'waiting_stocks.product_id')
            ->select('waiting_stocks.id','waiting_stocks.created_at','products.name','products.unit','products.unit_quantity','products.unit','waiting_stocks.quantity','waiting_stocks.total_price')
            ->get();

        $total=DB::table('waiting_stocks')
            ->sum(DB::raw('total_price'));

        return view('products.waiting-stock-list',['products'=>$res,'total'=>$total]);

    }


    public function save_waiting_list($id,$quantity,$total_price)
    {
        $values = array(
            'product_id' => $id,
            'quantity' => $quantity,
            'total_price' => $total_price,
            "created_at" =>  date('Y-m-d H:i:s'),
            "updated_at" =>  date('Y-m-d H:i:s')
        );
        $res=DB::table('waiting_stocks')->insert($values);

        return  response()->json($res);

    }



    public function del_waiting_list($id){
        DB::table('waiting_stocks')->where('id', '=', $id)->delete();

        return redirect()->back();
    }



    public function all_inactive_customers(){
        return view('water.all-customer-last-order');
    }
    public function all_inactive_customers_list(){
        $result =DB::table('shippings')
                ->select('phone')
                ->groupBy('phone')
                ->get();

        $data=  [];
        foreach ($result as $customer){
            $list = DB::table('shippings')
                ->where('shippings.phone', '=',$customer->phone)
                ->orderBy('shippings.id','desc')
                ->first();
            array_push($data,$list);
        }

        return  response()->json($data);
    }


    public function inactive_customers_list(){
        $result = DB::table('water_customers')
            ->where('status' ,'=', 1)
            ->get();

        $data=  [];
        foreach ($result as $customer){

            $list = DB::table('shippings')
                ->join('water_customers', 'water_customers.phone', '=', 'shippings.phone')
                ->where('shippings.phone', '=',$customer->phone)
                ->orderBy('shippings.id','desc')
                ->select('water_customers.comment','water_customers.name','shippings.phone','shippings.area','shippings.address','shippings.created_at')
                ->first();
            array_push($data,$list);
        }
        //dd($data);
//        $days=  [];
//        foreach ($data as $single){
//
//            $now = time(); // or your date as well
//            $your_date = strtotime($single->created_at);
//            $datediff = $now - $your_date;
//            $day = round($datediff / (60 * 60 * 24));
//
//            array_push($days,$single->created_at);
//        }

        return  response()->json($data);
    }



    public function inactive_customers(){
        $today_date = date('Y-m-d h:i:s');

        $locations = DB::table('delivery_locations')
            ->get();

        $result = DB::table('water_customers')
            ->where('status' ,'=', 1)
            ->get();

        $data = [];
        foreach ($result as $customer){
            $list = DB::table('shippings')
                ->where('shippings.phone', '=',$customer->phone)
                ->orderBy('shippings.id','desc')
                ->first();
             if($list){
                 array_push($data, $list);
             }
        }

//dd($data);
//        $days=  array();
//
//        foreach ($data as $row){
//
//         $now = time(); // or your date as well
//          $your_date = strtotime($row->created_at);
//
//          $datediff = $now - $your_date;
//
//          $day = round($datediff / (60 * 60 * 24));
//
//          array_push($days,1);
//
//            }
//
//       dd($days);

        //return  response()->json($data);

       return view('water.inactive-customers');
       //return view('water.inactive-customers',['customers' => (object)$data ,'locations'=>$locations]);
    }


    public function comment($customer_id,$date,$comment)
    {
        $month=date('m');
        $year=date('Y');
        $day_key="c".$date;
            $update =  DB::table('waters')
                ->where('customer_id', $customer_id)
                ->where('month', $month)
                ->where('year', $year)
                ->update([$day_key => $comment]);
            return  response()->json('ok');

    }


    public function water_price($customer_id,$jarprice)
    {

        $update_sell =  DB::table('water_customers')
            ->where('id', $customer_id)
            ->update(['price' => $jarprice]);

        return $update_sell;
    }

    public function tota_dis_jar($customer_id,$tota_dis_jar)
    {

        $update_sell =  DB::table('water_customers')
            ->where('id', $customer_id)
            ->update(['jar' => $tota_dis_jar]);

        return $update_sell;
    }



    public function sell_water($customer_id,$date,$sell_amount)
    {
        $month=date('m');
        $year=date('Y');
        $day_key="d_".$date."_sell";
        $update_sell =  DB::table('waters')
            ->where('customer_id', $customer_id)
            ->where('month', $month)
            ->where('year', $year)
            ->update([$day_key => $sell_amount]);

        return $update_sell;
    }

    public function collect_water_jar($customer_id,$date,$get_bottle)
    {
        $month=date('m');
        $year=date('Y');
        $day_key="d_".$date."_in";
        $update_sell =  DB::table('waters')
            ->where('customer_id', $customer_id)
            ->where('month', $month)
            ->where('year', $year)
            ->update([$day_key => $get_bottle]);

        return $update_sell;
    }

    public function updateWaterFromOrder(Request $request){

        $customer_info=DB::table('water_customers')
            ->where('phone', '=',$request->cus_phone)
            ->first();
        if($customer_info){
            $customer_id = $customer_info->id;

        }else{
            return  response()->json('Customer Not Found In water List');
        }
        $month = date('m');
        $year = date('Y');
        $day = ltrim(date('d') , '0');
        $day_key = 'd_'.$day.'_in';

//check  if month  inserted
        $user=DB::table('waters')
            ->where('customer_id', '=',$customer_id)
            ->where('year', '=',$year)
            ->where('month', '=',$month)
            ->count();
        if($user==0){
            $values = array('customer_id' => $customer_id,'year' => $year,'month' => $month);
            $res=DB::table('waters')->insert($values);
        }


        $update =  DB::table('waters')
            ->where('customer_id', $customer_id)
            ->where('month', $month)
            ->where('year', $year)
            ->update([$day_key => $request->jar_collected]);

        if($update == 1){
            return  response()->json('Jar Updated');
        }else{
            return  response()->json('Failed');
        }






    }


    public function customer_history($id)
    {

        $month=date('m');
        $year=date('Y');

        $jar_out = DB::table('waters')
            //->select(DB::raw('d_1_sell + d_2_sell'))
            ->where('customer_id', '=',$id)
//            ->where('year', '=',$year)
//            ->where('month', '=',$month)
            ->sum(DB::raw('d_1_sell + d_2_sell+ d_3_sell+ d_4_sell+ d_5_sell+ d_6_sell+ d_7_sell+ d_8_sell+ d_9_sell+ d_10_sell+ d_11_sell+ d_12_sell+ d_13_sell+ d_14_sell+ d_15_sell+ d_16_sell+ d_17_sell+ d_18_sell+ d_19_sell+ d_20_sell+ d_21_sell+ d_22_sell+ d_23_sell+ d_24_sell+ d_25_sell+ d_26_sell+ d_27_sell+ d_28_sell+ d_29_sell+ d_30_sell+ d_31_sell'))
        ;


        //dd( $jar_out);

        $jar_in = DB::table('waters')
            //->select(DB::raw('d_1_in + d_2_in'))
            ->where('customer_id', '=',$id)
//            ->where('year', '=',$year)
//            ->where('month', '=',$month)
            ->sum(DB::raw('d_1_in + d_2_in + d_3_in + d_4_in+d_5_in+d_6_in+d_7_in+d_8_in+d_9_in+d_10_in+d_11_in+d_12_in+d_13_in+d_14_in+d_15_in+d_16_in+d_17_in+d_18_in+d_19_in+d_20_in+d_21_in+d_22_in+d_23_in+d_24_in+d_25_in+d_26_in+d_27_in+d_28_in+d_29_in+d_30_in+d_31_in'))
        ;

       // dd( $jar_in);


        $user=DB::table('waters')
            ->where('customer_id', '=',$id)
            ->where('year', '=',$year)
            ->where('month', '=',$month)
            ->count();
        if($user==0){
            $values = array('customer_id' => $id,'year' => $year,'month' => $month);
            $res=DB::table('waters')->insert($values);
        }

        $user=DB::table('water_customers')
            ->where('water_customers.id', '=',$id)->first();

        $waters=DB::table('waters')
            ->where('customer_id', '=',$id)
            ->where('year', '=',$year)
            ->where('month', '=',$month)
            ->first();
        $filters = DB::table('water_customers')
            ->where('id', '=',$id)
            ->sum(DB::raw('jar'));


        return view('water.index',['user'=>$user,'waters'=>$waters,'filters'=>$filters,'total_jar_out'=>$jar_out,'total_jar_in'=>$jar_in]);
    }



    public function save_water_customer(Request $request)
    {
        $values = array('name' => $request->name,'phone' => $request->phone,'area_id' => $request->area,'address' => $request->address);
        $res=DB::table('water_customers')->insert($values);
        $request->session()->flash('status', ' Customer  added successfully!');

        return redirect()->back();

    }

    public function update_water_customer(Request $request)
    {

        DB::table('water_customers')->where('id', $request->id)->update(
            [
                'name' => $request->name,
                'phone'=>$request->phone,
                'area_id'=>$request->area,
                'status'=>$request->status,
                'address'=>$request->address
            ]);

        $request->session()->flash('status', ' Customer  Updated successfully!');

        if(Auth::user()->role=='admin'){
            return redirect('ad/water_customer/lists');
        }elseif(Auth::user()->role=='manager'){
            return redirect('pm/water_customer/lists');
        }


    }



    public function edit_water_customer($id)
    {

        $customer = DB::table('water_customers')
           ->where('water_customers.id', '=',$id)
            ->first();
        $areas=DB::table('delivery_locations')->get();
        return view('water.edit', ['customer' => $customer,'areas'=>$areas]);

    }



    public function disable_water_customers()
    {

        $customers=DB::table('water_customers')
            ->where('water_customers.status', '=',0)
            ->get();

        return view('water.disable-list',['customers'=>$customers]);

    }

    public function show_water_customer()
    {
        $total_filters = DB::table('assets')
            ->where('assets.type', '=','Filter')
            ->sum(DB::raw('quantity'));
        $total_jars = DB::table('assets')
            ->where('assets.type', '=','Bottle')
            ->sum(DB::raw('quantity'));

        $filters = DB::table('water_customers')
            ->sum(DB::raw('jar'));

        $jar_out = DB::table('waters')
            ->sum(DB::raw('d_1_sell + d_2_sell+ d_3_sell+ d_4_sell+ d_5_sell+ d_6_sell+ d_7_sell+ d_8_sell+ d_9_sell+ d_10_sell+ d_11_sell+ d_12_sell+ d_13_sell+ d_14_sell+ d_15_sell+ d_16_sell+ d_17_sell+ d_18_sell+ d_19_sell+ d_20_sell+ d_21_sell+ d_22_sell+ d_23_sell+ d_24_sell+ d_25_sell+ d_26_sell+ d_27_sell+ d_28_sell+ d_29_sell+ d_30_sell+ d_31_sell'));

        //dd( $jar_out);

        $jar_in = DB::table('waters')
            ->sum(DB::raw('d_1_in + d_2_in + d_3_in + d_4_in+d_5_in+d_6_in+d_7_in+d_8_in+d_9_in+d_10_in+d_11_in+d_12_in+d_13_in+d_14_in+d_15_in+d_16_in+d_17_in+d_18_in+d_19_in+d_20_in+d_21_in+d_22_in+d_23_in+d_24_in+d_25_in+d_26_in+d_27_in+d_28_in+d_29_in+d_30_in+d_31_in'));
        //dd($jar_in);
        $customers=DB::table('water_customers')
            ->where('water_customers.status', '=',1)
            ->get();
        $areas=DB::table('delivery_locations')->get();

        $trash_jar = DB::table('trashes')
            ->where('trashes.type', '=','bottle')
            ->sum(DB::raw('quantity'));

        $trash_filter = DB::table('trashes')
            ->where('trashes.type', '=','filter')
            ->sum(DB::raw('quantity'));


        return view('water.water-customer-add',['total_filters'=>$total_filters - $trash_filter,'total_jars'=>$total_jars - $trash_jar,'filters'=>$filters,'customers'=>$customers,'areas'=>$areas,'jar_outside'=>$jar_out-$jar_in]);

    }


    public function print_water_customer()
    {
        $total_filters = DB::table('assets')
            ->where('assets.type', '=','Filter')
            ->sum(DB::raw('quantity'));
        $total_jars = DB::table('assets')
            ->where('assets.type', '=','Bottle')
            ->sum(DB::raw('quantity'));

        $filters = DB::table('water_customers')
            ->sum(DB::raw('jar'));

        $jar_out = DB::table('waters')
            ->sum(DB::raw('d_1_sell + d_2_sell+ d_3_sell+ d_4_sell+ d_5_sell+ d_6_sell+ d_7_sell+ d_8_sell+ d_9_sell+ d_10_sell+ d_11_sell+ d_12_sell+ d_13_sell+ d_14_sell+ d_15_sell+ d_16_sell+ d_17_sell+ d_18_sell+ d_19_sell+ d_20_sell+ d_21_sell+ d_22_sell+ d_23_sell+ d_24_sell+ d_25_sell+ d_26_sell+ d_27_sell+ d_28_sell+ d_29_sell+ d_30_sell+ d_31_sell'));

        //dd( $jar_out);

        $jar_in = DB::table('waters')
            ->sum(DB::raw('d_1_in + d_2_in + d_3_in + d_4_in+d_5_in+d_6_in+d_7_in+d_8_in+d_9_in+d_10_in+d_11_in+d_12_in+d_13_in+d_14_in+d_15_in+d_16_in+d_17_in+d_18_in+d_19_in+d_20_in+d_21_in+d_22_in+d_23_in+d_24_in+d_25_in+d_26_in+d_27_in+d_28_in+d_29_in+d_30_in+d_31_in'));
        //dd($jar_in);
        $customers=DB::table('water_customers')
            ->join('delivery_locations', 'delivery_locations.id', '=', 'water_customers.area_id')
            ->where('water_customers.status', '=',1)
            ->orderBy('delivery_locations.water_location_serial', 'DESC')
            ->get();
        $areas=DB::table('delivery_locations')->get();

        $trash_jar = DB::table('trashes')
            ->where('trashes.type', '=','bottle')
            ->sum(DB::raw('quantity'));

        $trash_filter = DB::table('trashes')
            ->where('trashes.type', '=','filter')
            ->sum(DB::raw('quantity'));

        return view('water.print-customers',['total_filters'=>$total_filters - $trash_filter,'total_jars'=>$total_jars - $trash_jar,'filters'=>$filters,'customers'=>$customers,'areas'=>$areas,'jar_outside'=>$jar_out-$jar_in]);

    }


    public function index()
    {
        return view('water.index');
    }

    public function save_marketer(Request $request)
    {
        $marketer = new marketer();
        $marketer->user_id = $request->user_id;
        $marketer->coupon_code=$request->coupon_code;
        $marketer->status=1;
        $marketer->save();
        $request->session()->flash('status', ' New Marketer  added successfully!');
        return redirect('ad/assign-marketer');


    }



    public function all_users()
    {
        $users = DB::table('users')
            //->where('users.role', '!=',3)
            ->orderBy('users.email', 'DESC')
            ->get();

        return view('user.index', ['users' => $users]);
    }



    public function new_user()
    {
        return view('user.create');
    }
    public function single_user($id)
    {

        $user = DB::table('users')
            ->where('users.id', '=', $id)
            ->select('users.*')
            ->first();

        return view('user.single', ['user' => $user]);
    }

    public function update_single_user(Request $request)
    {
        if(strlen($request->password)>0){
            DB::table('users')->where('id', $request->id)->update(['name' => $request->name,'email'=>$request->email,'phone'=>$request->phone,'password'=>Hash::make($request->password),'role'=>$request->role]);
        }else{
            DB::table('users')->where('id', $request->id)->update(['name' => $request->name,'email'=>$request->email,'phone'=>$request->phone,'role'=>$request->role]);
        }
        $request->session()->flash('status', 'User Updated Successfully');
        return redirect()->back();

    }

    public function save_user(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->phone=$request->phone;
        $user->role=$request->role;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->save();
        $request->session()->flash('status', ' New User  added successfully!');
        return redirect('ad/users');
    }


    public function authenticate(Request $request)
    {
        $credentials = $request->only('phone', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {

        $checkIfUserExist= DB::table('users')->where('phone', $request->phone)->count();
        //0 means  user  not exist
        if($checkIfUserExist==0){

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:15|unique:users',
                //'email' => 'required|string|email|max:255|unique:users',
                'role' => 'required|in:1,2,3', //validate role input 1  super admin 2  admin  , 3  customer
                'password' => 'required|string|min:6|confirmed',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }


            $user= User::create([
                'name' => $request->get('name'),
                //'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'role' => $request->get('role'),
                'password' => Hash::make($request->get('password')),
            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json(compact('user','token'),201);
        }else{
            $otp_code = rand(1000,9999);

            DB::table('otptokens')->insert(
                [
                    'token' => $otp_code,
                    'phone' => $request->phone,
                    "created_at" =>  date('Y-m-d H:i:s'),
                    "updated_at" =>  date('Y-m-d H:i:s')]
            );

            //1 means  user  exist
            //return response($checkIfUserExist);
        }
    }


    public function verify_OTP_token(Request $request){
        $match_token= DB::table('otptokens')->where('phone', $request->phone)->where('token', $request->token)->count();
        if($match_token==1){
            return response()->json([
                'message' => "<span class='green-color'><i class='fa fa-exclamation-triangle'></i> Token is  verified successfully.</span>",
                'status' => '30',
            ]);
        }else{
            return response()->json([
                'message' => "<span class='red-color'><i class='fa fa-exclamation-triangle'></i> Token is not  valid.</span>",
                'status' => '31',
            ]);
        }
    }


    public function send_token(Request $request){
        $checkIfUserExist= DB::table('users')->where('phone', $request->phone)->count();
        if($checkIfUserExist==0){
            $otp_code = rand(1000,9999);


            $url = "http://66.45.237.70/api.php";
            $number='88'.$request->phone;
            $text="Your GopalgonjBazar.com verification Code is $otp_code";
            $data= array(
                'username'=>'monircis',
                'password'=>'Monir6789Z',
                'number'=>$number,
                'message'=>$text
            );

            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $smsresult = curl_exec($ch);
            $p = explode("|",$smsresult);
            $sendstatus = $p[0];

            //return response()->json([
            //'message' => "Token Send",
            //'status' => $sendstatus,
            //    ]);

            $result=DB::table('otptokens')->insert(
                [
                    'token' => $otp_code,
                    'phone' => $request->phone,
                    "created_at" =>  date('Y-m-d H:i:s'),
                    "updated_at" =>  date('Y-m-d H:i:s')
                ]);
            if($result){
                //send token  througn sms

                return response()->json([
                    'message' => "<span>We've sent a 4-digit OTP Code  in your phone <b>+88$request->phone</b>.</span>",
                    'status' => '10',
                ]);
            }
        }else{
            return response()->json([
                'message' => "<span class='red-color'><i class='fa fa-exclamation-triangle'></i> You are already a registered User Please Login.</span>",
                'status' => '9',
            ]);

            //return response("Sorry  <b>+88$request->phone</b> number is not valid. Try Again");
        }

    }



    public function register_customer(Request $request)
    {

        $checkIfUserExist= DB::table('users')->where('phone', $request->phone)->count();
        //0 means  user  not exist
        if($checkIfUserExist==0){
            $match_token= DB::table('otptokens')->where('phone', $request->phone)->where('token', $request->token)->count();
            if($match_token==1){
                $user= User::create([
                    'name' => $request->get('name'),
                    //'email' => $request->get('email'),
                    'phone' => $request->get('phone'),
                    'role' => 3,
                    'password' => Hash::make($request->get('password')),
                ]);
                return response()->json([
                    'message' => "<span class='green-color'><i class='fa fa-exclamation-triangle'></i> You have registered Successfully Please Login.</span>",
                    'status' => '11',
                ]);
            }else{
                return response()->json([
                    'message' => "<span class='red-color'><i class='fa fa-exclamation-triangle'></i>  OTP Code Not Match</span>",
                    'status' => '12',
                ]);
            }
        }else{
            return response()->json([
                'message' => "<span class='green-color'><i class='fa fa-exclamation-triangle'></i>  User Exist Please Try another one.</span>",
                'status' => '13',
            ]);
        }
    }




    public function validate_token(Request $request){


        $tokendata= otptoken::where('phone',$request->phone)->where('token',$request->token)->get();

        $token_create_time = $tokendata[0]->created_at;

        if($token_create_time!=''){

            $check_time=date('2008-12-13 10:42:00');
            $check_time2=date('2008-12-13 10:12:00');
            $check_time2->diff($check_time); //$token_create_time->diff($check_time);


            $start  = new Carbon('2018-10-04 15:00:03');
            $end    = new Carbon('2018-10-05 17:00:09');
            $start->diff($end)->format('%H:%I:%S');
            $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', '2015-5-6 3:30:34');

            $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', '2015-5-6 3:30:54');


            $diff_in_minutes = $to->diffInMinutes($from);

            return 'pp'; // Output: 20


        }else{

        }




    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        $is_seller = DB::table('marketers')
            ->where('marketers.user_id', $user->id)
            ->count();


        return response()->json(compact('user','is_seller'));
    }

}