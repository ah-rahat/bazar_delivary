<?php

namespace App\Http\Controllers;

use App\User;
use App\otptoken;
use App\marketer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Mail;


class UserController extends Controller
{

//    public function update_profile(Request $request)
//    {
//        if (strlen($request->password) > 0) {
////            $result = DB::table('users')->where('id', $request->customer_id)->update(
////                [
////                    'name' => $request->name,
////                    'password' => Hash::make($request->password),
////                ]);
//            return response()->json([
//                'message' =>$request->customer_id
//            ]);
//        }
//
//    }



    public function notify_token_send(Request $request){

        $user = DB::table('users')
            ->where('users.email', '=', $request->email)
            ->first();
        $token = rand(1000,9999);
        $data = [
            "token" => $token,
            "phone" => $user->phone,
            "created_at" => now(),
            "updated_at" => now()
        ];

        $otp_row_id = DB::table('otptokens')->insertGetId($data);

        $input = [
            'name' => 'Gopalganj Bazar',
            'email' => 'gbjazarbd@gmail.com',
            'to' => $request->email,
            'code' => $token,
        ];

        Mail::send('otpcode_email',$input, function($mail) use ($input){
            $mail->from($input['email'],$input['name'])
                ->to($input['to'],'')
                ->subject('OTP Code From GopalganjBazar');
        });
        if($request->email_otp == null){
            $email_otp = 'email_otp';
        }

        return redirect('login?token='.$otp_row_id.'&sms_method='.$email_otp.'&email='.$request->email);
//        dd($request);
//        $checkIfUserExist= DB::table('users')->where('phone', $request->phone)->count();
    }


    public function affiliate_customer_activity_search($number)
    {

        $order = DB::table('shippings')
            ->where('phone','=', $number)
            ->select('created_at')
            ->first();
        $customer = DB::table('users')
            ->where('phone','=', $number)
            ->select('created_at')
            ->first();
        return response()->json([
            'order' =>$order,
            'customer' => $customer
        ]);

    }
    public function affiliate_sales_calculate(Request $request)
    {

        $phonelists = DB::table('affiliate_assign_customers')->where('affiliate_user_id','=', 1)->select('customer_phone')->get()->toArray();
        $arr = [];
        foreach($phonelists as $row)
        {
            $arr[] = (array) $row;
        }
        $orders = DB::table('shippings')
            ->join('orders', 'orders.id', '=', 'shippings.order_id')
            //->where('orders.active_status','=', 1)
            ->whereIn('shippings.phone', $arr)->select('shippings.order_id','orders.delivery_charge','orders.coupon_discount_amount')->get();
        //dd($orders);

        $order_id_list = [];
        foreach($orders as $order)
        {
            $order_id_list[] = (array) $order->order_id;
        }


        $total_sales_amount=0;
        $total_buy_amount=0;
        foreach($order_id_list as $order_id){
            $get_single_order = DB::table('order_items')
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->where('orders.active_status','=', 3)
                ->where('order_items.order_id','=', $order_id)
                //->select('customer_phone')
                ->select(DB::raw('sum(order_items.total_price) as sale_price'),DB::raw('sum(order_items.total_buy_price) as buy_price'))
                ->first();

            $total_sales_amount+= $get_single_order->sale_price;
            $total_buy_amount+= $get_single_order->buy_price;

//                 dd($get_single_order);

        }
        //return $total_buy_amount;

        $total_discount_amount = 0;
        foreach($orders as $order)
        {
            if($order->coupon_discount_amount > $order->delivery_charge){
                $discount = $order->coupon_discount_amount - $order->delivery_charge;
                $total_discount_amount+= $discount;
            }
        }

        $final_total_buy_amount = $total_discount_amount + $total_buy_amount;
        $sales_profit = ($total_sales_amount - $final_total_buy_amount);
        $affiliate_commission = round(10 * ($sales_profit / 100),2);

        return response()->json(['affiliate_commission' => $affiliate_commission]);
    }


    public function add_affiliate_customer(Request $request)
    {
        $count=  DB::table('affiliate_assign_customers')
            ->where('customer_phone', '=',$request->customer_phone)
            ->count();
        if($count==0){
            DB::table('affiliate_assign_customers')->insert(
                [
                    'affiliate_user_id' => $request->affiliator_id,
                    'customer_phone' => $request->customer_phone,
                    "created_at" =>  date('Y-m-d H:i:s'),
                    "updated_at" =>  date('Y-m-d H:i:s')]
            );
            return response()->json(['Success' => 'Data Stored']);
        }else{
            return response()->json(['error' => 'Data exist']);
        }

    }
    public function assign_affiliate_customer()
    {
        $marketers=  DB::table('marketers')
            ->join('users', 'marketers.user_id', '=', 'users.id')
            ->select('users.*','marketers.coupon_code as  coupon_code')
            ->get();

        return view('affiliate.index', ['marketers'=>$marketers]);

    }

       public function assign_marketer()
    {
        $users = DB::table('users')
         ->orderBy('users.name')
        ->get();
         $coupons = DB::table('coupons')
        ->get();
      
      
       $marketers=  DB::table('marketers')
            ->join('users', 'marketers.user_id', '=', 'users.id')
             ->select('users.*','marketers.coupon_code as  coupon_code')
            ->get();
   
        return view('coupon.marketer-coupon', ['users' => $users,'coupons'=>$coupons,'marketers'=>$marketers]);
    } 
     
       public function save_marketer(Request $request)
    {
        if($request->coupon_code){
          $coupon_code = $request->coupon_code;
        }else{
            $coupon_code = md5(uniqid(rand(), true));
        }
        $marketer = new marketer();
        $marketer->user_id = $request->user_id;
        $marketer->coupon_code=$coupon_code;
        $marketer->status=1;
        $marketer->save();
        $request->session()->flash('status', ' New Marketer  added successfully!');
        return redirect('ad/assign-marketer');
        
        
    }


    public function customers()
    {
        $users = DB::table('users')
            ->where('users.role', '=',3)
            ->orderBy('users.id', 'DESC')
            ->get();

        return view('user.customers', ['users' => $users]);
    }

    public function all_users()
    {
        $users = DB::table('users')
        ->where('users.role', '!=',3)
         ->orderBy('users.id', 'DESC')
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
        $credentials = $request->only('email', 'password');

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
        
         $checkIfUserExist= DB::table('users')->where('email', $request->email)->count();
         //0 means  user  not exist
         if($checkIfUserExist==0){

                   $user= User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
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