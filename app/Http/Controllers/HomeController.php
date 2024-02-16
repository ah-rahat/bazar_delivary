<?php

namespace App\Http\Controllers;

use App\Category;
use  App\product;
use App\sub_category;
use App\child_sub_cats;
use App\brand;
use App\restaurant;
use App\delivery_man;
use App\offer_image;
use App\order_item;
use App\order;
use App\prescription;
use App\regular_product;
use App\terms_condition;
use App\color;
use App\unit;
use Mail;
use Illuminate\Support\Collection;

use Carbon\vendor_request;
use Carbon\Carbon;

use App\product_requests;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Yuansir\Toastr\Facades\Toastr;

class HomeController extends Controller
{


    public function test_for_qury()
    {
        $result = DB::table('water_customers')
            ->where('status', '=', 1)
            ->get();
        $today_date = date('Y-m-d ');
        $data = [];
        foreach ($result as $customer) {

            $list = DB::table('shippings')
                ->join('water_customers', 'water_customers.phone', '=', 'shippings.phone')
                ->where('shippings.phone', '=', $customer->phone)
                ->orderBy('shippings.id', 'desc')
                ->select('water_customers.comment', 'water_customers.name', 'shippings.phone', 'shippings.area', 'shippings.address', 'shippings.created_at', DB::raw(('*, datediff(shippings.created_at, now())')))
                ->first();
            dd($list);
            array_push($data, $list);
        }
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

        return response()->json($data);


        $previous_orders = DB::table('orders')
            ->where('orders.customer_id', '=', 1)
            ->select('orders.id as order_id')
            ->orderBy('orders.id', 'desc')
            ->limit(3)
            ->get();
        $arr = [];
        foreach ($previous_orders as $row) {
            $arr[] = $row->order_id;
        }

        $shippings = DB::table('shippings')
            ->whereIn('order_id', $arr)
            ->select('shippings.address as shipping_address')
            ->get();
        dd($shippings);

        $today_date = date('2021-09-08');

        $total_buy_amount = DB::table('orders')
            //->whereDate('delivered_date', '=', date('Y-m-d'))
            ->where('delivered_date', '>=', $today_date . ' 00:00:00')
            ->where('delivered_date', '<=', $today_date . ' 23:59:59')
            ->where('active_status', '=', 3)
            ->select('id')
            ->get();


        $sales_summary = DB::table('orders')
            //->whereDate('delivered_date', '=', date('Y-m-d'))
            ->where('delivered_date', '>=', $today_date . ' 00:00:00')
            ->where('delivered_date', '<=', $today_date . ' 23:59:59')
            ->where('orders.active_status', '=', 3)
            ->select(DB::raw('sum(order_total) as order_total'), DB::raw('sum(delivery_charge) as delivery_charge'),
                DB::raw('sum(coupon_discount_amount) as coupon_discount_amount'))
            ->first();
        dd($total_buy_amount);

//            ->where('created_at', '>=', $today_date . ' 00:00:00')
//            ->where('created_at', '<=', $today_date . ' 23:59:59')
//            ->join('products', 'products.id', '=', 'product_stocks.product_id')
//            ->select('products.name','products.unit','products.unit_quantity','product_stocks.quantity','product_stocks.price')
//            ->get();


        $approve_orders = DB::table('orders')
            ->whereIn('active_status', [1, 2])
            ->select('id')->get()->toArray();
        //dd($approve_orders);

        $total_buy_price = 0;
        foreach ($approve_orders as $order) {
            $get_single_order = DB::table('products')
                ->where('products.id', '=', 3)
                ->where('order_items.order_id', '=', $order_id)
                //->select('customer_phone')
                ->select(DB::raw('sum(order_items.total_price) as sale_price'), DB::raw('sum(order_items.total_buy_price) as buy_price'))
                ->first();
            $total_sales_amount += $get_single_order->sale_price;
            $total_buy_amount += $get_single_order->buy_price;
        }

        $phonelists = DB::table('affiliate_assign_customers')->where('affiliate_user_id', '=', 514)->select('customer_phone')->get()->toArray();
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

        return response()->json(['affiliate_commission' => $affiliate_commission]);


        $today_date = date('Y-m-d');
        $check_if_not_price_add = DB::table('orders')
            ->where('delivered_date', '>=', $today_date . ' 00:00:00')
            ->where('delivered_date', '<=', $today_date . ' 23:59:59')
            ->where('active_status', '=', 3)
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('order_items.total_buy_price', '<=', 0)
            ->select('orders.id as pending_id')
            ->get();
        // dd($check_if_not_price_add);
        //SELECT COUNT(quantity) FROM order_items WHERE order_id IN (1486,1497,1500,1501,1502,1503,1504,1505,1506,1507,1508,1509,1510,1511,1512,1513,1514,1515,1516,1517,1518,1519,1520,1521,1522,1523,1524,1525,1526,1527,1528,1529,1530,1531,1532,1533,1534,1535,1536,1537,1538,1539,1540,1541,1542,1543,1544,1545) AND product_id=6824 

        $today_orders = DB::table('orders')
            ->where('orders.delivered_date', '>=', '2020-12-31 00:00:00')
            ->where('orders.delivered_date', '<=', '2020-12-31 23:59:59')
            ->where('orders.active_status', '=', 3)
            ->select('orders.id')
            ->get();
        dd($today_orders);
    }


    public function map_location()
    {
        $customers = DB::table('map_locations')
            ->get();
        return view('locations.map-location', ['customers' => $customers]);
    }
    public function delete_map_location(Request $request)
    {
        $id = $request->id;
         DB::table('map_locations')
            ->where('id', '=', $id)
            ->delete();
        return redirect()->back();

    }


    public function map_location_store(Request $request)
    {

        DB::table('map_locations')->insert([
            'phone' => $request->phone,
            'map_url' => $request->url,
            'added_by' => Auth::id()
        ]);
        $request->session()->flash('status', 'Added Successfully');
        return redirect()->back();


    }


    public function buy_price_added_products()
    {

        $products = DB::table('products')
            ->where('products.buy_price', '>', '0')
            ->where('products.real_stock', '=', '0')
            ->select('products.*')
            ->get();

        return view('products.buy_price_added_products', ['products' => $products]);
    }

    public function dayend_sold_products($date)
    {

        $date = date('Y-m-d', strtotime($date));

        $orders = DB::table('orders')
            ->where('orders.delivered_date', '>=', $date . ' 00:00:00')
            ->where('orders.delivered_date', '<=', $date . ' 23:59:59')
            ->where('orders.active_status', '=', 3)
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->select('orders.id as  order_id', 'order_items.product_id as product_id', 'order_items.total_buy_price', 'order_items.total_price', 'products.name', 'products.name_bn', 'products.unit', 'products.unit_quantity')
            ->orderBy('orders.id', 'DESC')
            ->get();
        $orders_discount = DB::table('orders')
            ->where('orders.delivered_date', '>=', $date . ' 00:00:00')
            ->where('orders.delivered_date', '<=', $date . ' 23:59:59')
            ->where('orders.active_status', '=',  3)
            ->get();

        return view('orders.today-sold-products', ['orders' => $orders,'orders_discount'=>$orders_discount]);
    }

    public function search_stock(Request $request)
    {

        $id = $request->id;
        $product = DB::table('products as p')
            ->where('p.id', '=', $id)
            ->first();

        $stocks = DB::table('product_stocks')
            ->where('product_stocks.product_id', '=', $id)
            ->join('products', 'products.id', '=', 'product_stocks.product_id')
            ->select('products.name', 'products.id', 'products.name_bn', 'products.unit', 'products.unit_quantity', 'product_stocks.quantity as product_stock_quantity', 'product_stocks.expire_date', 'product_stocks.created_at')
            ->get();

        $products = DB::table('products')
            ->where('status', '=', 1)
            ->select('products.id', 'products.name', 'products.name_bn', 'products.unit', 'products.unit_quantity')
            ->get();

        return view('products.add-stock', ['stocks' => $stocks, 'searchvalue' => $id, 'products' => $products]);
    }

    public function store_stock($date, $product_id, $stock_quantity, $price)
    {
        DB::beginTransaction();
        try {
            $product = DB::table('products')
                ->where('id', '=', $product_id)
                ->first();
            $old_stock_quantity = $product->stock_quantity;
            $old_stock_buy_price = $product->buy_price;
            $total_buy_price = $product->buy_price * $product->stock_quantity + $price;
            $new_stock_quantity = $stock_quantity + $old_stock_quantity;
            $new_buy_price = round($total_buy_price / $new_stock_quantity, 2);

            //update  price
            $update = DB::table('products')->where('id', $product_id)->update(['stock_quantity' => $new_stock_quantity, 'buy_price' => ceil($new_buy_price * 100) / 100]);

            $stock = DB::table('product_stocks')->insert([
                'product_id' => $product_id,
                'expire_date' => $date,
                'quantity' => $stock_quantity,
                'price' => $price,
                'old_stock' => $old_stock_quantity,
                'old_buy_price' => $old_stock_buy_price,
                'user_id' => Auth::id(),
                'created_at' => Carbon::now()
            ]);
            DB::commit();
            return response()->json([
                'stock' => $stock,
                'update_stock' => $update
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), $e->getCode());
            // something went wrong
        }

    }


    public function temp_store_stock($date, $product_id, $stock_quantity, $price)
    {
        DB::beginTransaction();
        try {
            $product = DB::table('products')
                ->where('id', '=', $product_id)
                ->first();
            $old_stock_quantity = $product->stock_quantity;
            $old_stock_buy_price = $product->buy_price;
            $total_buy_price = $product->buy_price * $product->stock_quantity + $price;
            $new_stock_quantity = $stock_quantity + $old_stock_quantity;
            $new_buy_price = round($total_buy_price / $new_stock_quantity, 2);

            $stock = DB::table('products_temp_stock')->insert([
                'product_id' => $product_id,
                'expire_date' => $date,
                'quantity' => $stock_quantity,
                'total_buy_price' => $price,
                'user_id' => Auth::id(),
                'created_at' => Carbon::now()
            ]);
            DB::commit();
            return response()->json([
                'stock' => $stock,
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), $e->getCode());
            // something went wrong
        }

    }

    public function findsales_quantity($product_id)
    {
        $stock = DB::table('order_items')
            ->where('product_id', '=', $product_id)
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.active_status', '=', 3)
            ->select(DB::raw('sum(quantity) as get_total'))
            ->first();
        $isinSale = DB::table('order_items')
            ->where('product_id', '=', $product_id)
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereIn('active_status', [0, 1, 2])
            ->select(DB::raw('sum(quantity) as get_total'))
            ->first();
        $stockLists = DB::table('product_stocks')
            ->where('product_id', '=', $product_id)
            ->join('users', 'users.id', '=', 'product_stocks.user_id')
            ->select('product_stocks.id as product_stock_id', 'product_stocks.quantity', 'product_stocks.price', 'product_stocks.expire_date', 'product_stocks.created_at', 'users.name')
            ->orderBy('product_stocks.id', 'desc')
            ->get();
        return response()->json([
            'quantity' => $stock,
            'isinSale' => $isinSale,
            'stockLists' => $stockLists
        ]);
    }

    public function stock_index()
    {
        return view('products.add-stock');
    }

    public function temp_products_stock()
    {
        $products = DB::table('products')
            ->get();
        $temp_stocks = DB::table('products_temp_stock')
            ->where('is_deleted', '=', 0)
            ->get();
        $temp_stocks_price = DB::table('products_temp_stock')
            ->where('is_deleted', '=', 0)
            ->select(DB::raw('sum(total_buy_price) as total_buy_price'))
            ->first();

        return view('products.temp-stock-product-add', ['products' => $products, 'temp_stocks' => $temp_stocks,'temp_stocks_price' => $temp_stocks_price]);
    }

    public function temp_products_stock_verify(){
        return view('products.temp-stock-product-verify');
    }


    public function unit_form()
    {
        return view('unit-add');
    }

    public function save_unit(Request $request)
    {
        $unit = new unit();
        $unit->unit_name = $request->unit_name;
        $unit->save();
        $request->session()->flash('status', 'Unit Added Successfully');
        return redirect()->back();
    }

    public function vendor_requests()
    {

        $vendor_requests = DB::table('vendor_requests')
            ->orderBy('vendor_requests.id', 'DESC')
            ->get();
        return view('vendor.vendor_requests', ['vendor_requests' => $vendor_requests]);
    }

    public function check_vendor_status($id)
    {
        DB::table('vendor_requests')->where('id', $id)->update(['status' => 1]);
        return redirect()->back();
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function prescriptions_checked($id)
    {
        DB::table('prescriptions')->where('id', $id)->update(['status' => 1]);
        return redirect()->back();

    }


    public function serch_product($value)
    {

        $id = trim($value);
        $products = DB::table('products')
            //->where('status', '=', 1)
            ->where('name', 'like', '%' . $id . '%')
            ->orWhere('name_bn', 'like', '%' . $id . '%')
            //->orWhere('slug', 'like', '%' . $id . '%')
            ->orWhere('tags', 'like', '%' . $id . '%')
            ->get();

        return response()->json([
            'products' => $products
        ]);


    }


    public function prescriptions_lists()
    {

        $users = DB::table('users')
            ->get();
        $prescriptions = DB::table('prescriptions')
            ->orderBy('prescriptions.id', 'DESC')
            ->paginate(15);
        return view('prescriptions.index', ['prescriptions' => $prescriptions, 'users' => $users]);
    }


    public function medicines_lists()
    {

        $products = DB::table('products as p')
            //->join('brands as b', 'p.brand_id', '=', 'b.id') 
            ->select('p.id', 'p.name', 'p.price', 'p.discount', 'p.unit_quantity', 'p.status', 'p.generic_name', 'p.stock_quantity', 'p.featured_image', 'p.unit', 'p.DAR')
            ->where('p.category_id', '=', '14')
            ->orderBy('p.id', 'DESC')
            ->paginate(50);
        return view('medicines.index', ['products' => $products, 'searchvalue' => '']);
    }

    public function search_medicines(Request $request)
    {

        $id = trim($request->id);
        $products = DB::table('products as p')
            //->where('status', '=', 1)
            ->where('name', 'like', '%' . $id . '%')
            ->orWhere('name_bn', 'like', '%' . $id . '%')
            //->orWhere('slug', 'like', '%' . $id . '%')
            ->orWhere('tags', 'like', '%' . $id . '%')
            ->select('p.id', 'p.name', 'p.price', 'p.discount', 'p.unit_quantity', 'p.status', 'p.generic_name', 'p.stock_quantity', 'p.featured_image', 'p.unit', 'p.DAR')
            ->get();
        return view('medicines.index', ['products' => $products, 'searchvalue' => $id]);
    }


    public function popup()
    {
        $offer = DB::table('offer_images')->where('id', 1)->first();
        return view('offer', ['offer' => $offer]);
    }

    public function update_offer(Request $request)
    {

        $popup_img = $request->file('popup_img');
        $old_image = $request->old_image;

        if ($popup_img != '') {

            $image = $popup_img;
            //img  file  code  START
            //unique  file name
            $filename = time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            //Image::make($image_resize)->resize(400, null, function($constraint) {
            //  $constraint->aspectRatio();
            //});
            $image_resize->save('uploads/offer_image/' . $filename);
            //img  file  code  end
            $popup_img_name = $filename;
        } else {
            $popup_img_name = $old_image;
        }

        DB::table('offer_images')->where('id', 1)
            ->update(['status' => $request->status, 'color' => $request->color, 'url' => $request->url, 'offer_image' => $popup_img_name]);

        $request->session()->flash('status', 'Offer Image Updated successfully!');
        return redirect()->back();

    }


    public function terms()
    {
        $terms = DB::table('terms_conditions')->where('id', 1)->first();;
        return view('terms', ['terms' => $terms]);
    }


    public function update_terms(Request $request)
    {
        $description = utf8_encode($request->description);
        DB::table('terms_conditions')->where('id', 1)->update(['description' => $description]);
        $request->session()->flash('status', 'Terms Updated Successfully');
        return redirect()->back();
    }

    public function request_list()
    {
        $requests = DB::table('product_requests')
            ->orderBy('product_requests.id', 'DESC')
            ->get();
        return view('orders.request', ['requests' => $requests]);

    }

    public function request_update($id)
    {
        DB::table('product_requests')->where('id', $id)->update(['status' => 1]);
        return redirect()->back();
    }


    public function change_password()
    {
        return view('change-password');

    }

    public function update_password(Request $request)
    {
        $userId = Auth::id();
        $new_password = $request->new_password;
        $c_password = $request->c_password;
        if ($c_password === $new_password) {
            DB::table('users')
                ->where('id', $userId)->update(
                    [
                        'password' => Hash::make($new_password)
                    ]);
            $request->session()->flash('status', ' Password changed Successfully');
            return redirect()->back();
        } else {
            $request->session()->flash('status', ' Password  and  confirm password does  not match');
            return redirect()->back();
        }
        //$new_password=Hash::make($request->new_password);
//           $checking = DB::table('users')
//            ->where('users.id', '=', $userId)
//            ->where('users.password', '=', Hash::make($request->password)) 
//            ->count();
//            return $checking;
//         if($checking==1){
//            
//         }

    }

    public function order_index()
    {
        $orders = DB::table('orders')
            ->join('shippings', 'orders.id', '=', 'shippings.order_id')
            ->whereIn('orders.active_status', [0, 1, 2, 3])
            ->select('orders.*', 'orders.id as  order_id', 'shippings.name as  name', 'shippings.phone as  phone')
            ->orderBy('orders.id', 'DESC')
            ->get();

        return view('orders.index', ['orders' => $orders]);
    }

    public function today_orders()
    {

        $today_date = date('Y-m-d');
        $orders = DB::table('orders')
            ->join('shippings', 'orders.id', '=', 'shippings.order_id')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.created_at', '>=', $today_date . ' 00:00:00')
            ->where('order_items.product_id', '!=', 37435)
            ->where('orders.created_at', '<=', $today_date . ' 23:59:59')
            ->whereIn('orders.active_status', [0, 1, 2])
            ->select('orders.*', 'orders.id as  order_id', 'shippings.name as  name', 'shippings.phone as  phone')
            ->orderBy('orders.id', 'desc')
            ->groupBy('orders.id')
            ->get();

        $old_orders = DB::table('orders')
            ->join('shippings', 'orders.id', '=', 'shippings.order_id')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.created_at', '<', $today_date . ' 00:00:00')
            ->whereIn('orders.active_status', [0, 1, 2])
            ->where('order_items.product_id', '!=', 37435)
            ->select('orders.*', 'orders.id as  order_id', 'shippings.name as  name', 'shippings.phone as  phone')
            ->orderBy('orders.id', 'desc')
            ->groupBy('orders.id')
//            ->orderBy('orders.id', 'DESC')
            ->get();

        return view('orders.today-orders', ['orders' => $orders, 'old_orders' => $old_orders, 'date' => '']);
    }

    public function previous_day_orders($date)
    {

        $orders = DB::table('orders')
            ->join('shippings', 'orders.id', '=', 'shippings.order_id')
            ->where('orders.created_at', '>=', $date . ' 00:00:00')
            ->where('orders.created_at', '<=', $date . ' 23:59:59')
            ->whereNotIn('orders.active_status', [3, 4])
            ->select('orders.*', 'orders.id as  order_id', 'shippings.name as  name', 'shippings.phone as  phone')
            ->orderBy('orders.id', 'DESC')
            ->get();


        return view('orders.today-orders', ['orders' => $orders, 'date' => $date]);
    }

    public function today_delivered_orders($date)
    {

        $today = date('Y-m-d', strtotime($date));
        $orders = DB::table('orders')
            ->join('shippings', 'orders.id', '=', 'shippings.order_id')
            ->where('orders.delivered_date', '>=', $today . ' 00:00:00')
            ->where('orders.delivered_date', '<=', $today . ' 23:59:59')
            ->where('orders.active_status', '=', 3)
            ->select('orders.*', 'orders.id as  order_id', 'shippings.name as  name', 'shippings.phone as  phone')
            ->orderBy('orders.id', 'DESC')
            ->get();


        return view('orders.today-delivered-orders', ['orders' => $orders, 'date' => $today]);
    }

    public function single_order_test($id)
    {

        $order_custumer_info = DB::table('orders')
            //->join('users', function ($join)use($id) {
            //  $join->on('users.id', '=', 'orders.customer_id')
            //      ->where('orders.id', '=', $id);
            // })
            ->join('payments', 'payments.order_id', '=', 'orders.id')
            ->join('shippings', 'shippings.order_id', '=', 'orders.id')
            ->where('orders.id', '=', $id)
            ->select('orders.*', 'shippings.name as  name', 'shippings.phone as  phone', 'shippings.address as  address', 'shippings.order_id as  order_id', 'shippings.area as  area', 'payments.payment_type as  payment_type', 'payments.transaction_number as  transaction_number')
            ->first();

        $order_products = DB::table('order_items')->where('order_id', $id)->get();
        $products = DB::table('products')->get();

        return view('orders.custom-order', ['order_products' => $order_products, 'products' => $products, 'order_custumer' => $order_custumer_info, 'order_id' => $id]);
    }


    public function order_product_buy_price_update($order_id, $product_id, $buy_price)
    {
        return DB::table('order_items')
            ->where(['order_id' => $order_id, 'product_id' => $product_id])
            ->update(['total_buy_price' => $buy_price]);

    }


    public function single_order($id)
    {
        DB::beginTransaction();
        try {
            $order_custumer_info = DB::table('orders')
                //->join('users', function ($join)use($id) {
                //  $join->on('users.id', '=', 'orders.customer_id')
                //      ->where('orders.id', '=', $id);
                // })
                ->join('payments', 'payments.order_id', '=', 'orders.id')
                ->join('shippings', 'shippings.order_id', '=', 'orders.id')
                ->where('orders.id', '=', $id)
                ->select('orders.*', 'shippings.name as  name', 'shippings.area_id as  area_id', 'shippings.phone as  phone', 'shippings.address as  address', 'shippings.order_id as  order_id', 'shippings.area as  area', 'payments.payment_type as  payment_type', 'payments.transaction_number as  transaction_number','shippings.delivery_time')
                ->first();

            if ($order_custumer_info->delivered_date) {
                $today = date('Y-m-d');
                $deliverd_date = date('Y-m-d', strtotime($order_custumer_info->delivered_date));
                $start_date = \Carbon\Carbon::createFromFormat('Y-m-d', $deliverd_date);
                $end_date = \Carbon\Carbon::createFromFormat('Y-m-d', $today);
                $different_days = $start_date->diffInDays($end_date);
            } else {
                $different_days = 0;
            }

            $order_products = DB::table('order_items')
                ->where('order_items.order_id', $id)
                ->join('products', 'products.id', '=', 'order_items.product_id')
                ->select('order_items.*', 'products.name', 'products.name_bn', 'products.strength',
                    'products.unit_quantity', 'products.unit',
                    'products.featured_image',
                    'products.buy_price'
                )
                ->get();


            $restaurants = restaurant::all();

            $get_order_total = DB::table('order_items')
                ->where('order_items.order_id', $id)
                ->select(DB::raw('sum(total_price) as get_order_total'))
                ->first();

            $delivery_mans = DB::table('delivery_mans')->where('status', 1)->get();
            $customize_products = DB::table('customize_products')->get();
            //fins buy  price is  empty
            $empty_buy_price_count = DB::table('orders')
                ->where('orders.id', '=', $id)
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->where('order_items.total_buy_price', '<=', 0)
                ->count();

            //profit calculate
            $total_buy_amount = DB::table('orders')
                ->where('orders.id', '=', $id)
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->select(DB::raw('sum(order_items.total_buy_price) as total_buy_price'))
                ->first();

            $total_sale_amount = DB::table('orders')
                ->where('orders.id', '=', $id)
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->select(DB::raw('sum(order_items.total_price) as total_sale_price'))
                ->first();

            $profit = $total_sale_amount->total_sale_price - $total_buy_amount->total_buy_price + $order_custumer_info->delivery_charge - $order_custumer_info->coupon_discount_amount;

          

            DB::commit();
            return view('orders.single-order', ['empty_buy_price_count' => $empty_buy_price_count, 'different_days' => $different_days, 'profit' => $profit, 'customize_products' => $customize_products, 'delivery_mans' => $delivery_mans, 'restaurants' => $restaurants, 'get_order_total' => $get_order_total, 'order_products' => $order_products, 'order_custumer' => $order_custumer_info, 'order_id' => $id]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), $e->getCode());
            // something went wrong
        }
    }

    public function single_order_print($id)
    {
        //$order_custumer_info=  DB::table('orders')
        // ->join('users', function ($join)use($id) {
        //  $join->on('users.id', '=', 'orders.customer_id')
        //  ->where('orders.id', '=', $id);
        //})
        //->join('payments', 'payments.order_id', '=', 'orders.id')
        //->first();
        // dd($order_custumer_info);


        $order_custumer_info = DB::table('orders')
            ->join('payments', 'payments.order_id', '=', 'orders.id')
            ->join('shippings', 'shippings.order_id', '=', 'orders.id')
            ->where('orders.id', '=', $id)
            ->select('orders.*', 'shippings.name as  name', 'shippings.phone as  phone', 'shippings.address as  address', 'shippings.order_id as  order_id', 'shippings.area as  area', 'payments.payment_type as  payment_type', 'payments.transaction_number as  transaction_number')
            ->first();
        $restaurents = DB::table('restaurants')->get();
        $order_products = DB::table('order_items')->where('order_id', $id)->get();
        $products = product::all();
        return view('orders.print', ['restaurents' => $restaurents, 'order_products' => $order_products, 'products' => $products, 'order_custumer' => $order_custumer_info, 'order_id' => $id]);
    }

    public function single_order_en_print($id)
    {

        $order_custumer_info = DB::table('orders')
            ->join('payments', 'payments.order_id', '=', 'orders.id')
            ->join('shippings', 'shippings.order_id', '=', 'orders.id')
            ->where('orders.id', '=', $id)
            ->select('orders.*', 'shippings.name as  name', 'shippings.phone as  phone', 'shippings.address as  address', 'shippings.order_id as  order_id', 'shippings.area as  area', 'payments.payment_type as  payment_type', 'payments.transaction_number as  transaction_number')
            ->first();
        $restaurents = DB::table('restaurants')->get();
        $order_products = DB::table('order_items')->where('order_id', $id)->get();
        $products = product::all();
        return view('orders.print-en', ['restaurents' => $restaurents, 'order_products' => $order_products, 'products' => $products, 'order_custumer' => $order_custumer_info, 'order_id' => $id]);
    }


    public function order_buy_price_print($id)
    {
        //$order_custumer_info=  DB::table('orders')
        // ->join('users', function ($join)use($id) {
        //  $join->on('users.id', '=', 'orders.customer_id')
        //  ->where('orders.id', '=', $id);
        //})
        //->join('payments', 'payments.order_id', '=', 'orders.id')
        //->first();
        // dd($order_custumer_info);


        $order_custumer_info = DB::table('orders')
            ->join('payments', 'payments.order_id', '=', 'orders.id')
            ->join('shippings', 'shippings.order_id', '=', 'orders.id')
            ->where('orders.id', '=', $id)
            ->select('orders.*', 'shippings.name as  name', 'shippings.phone as  phone', 'shippings.address as  address', 'shippings.order_id as  order_id', 'shippings.area as  area', 'payments.payment_type as  payment_type', 'payments.transaction_number as  transaction_number')
            ->first();

        $order_products = DB::table('order_items')->where('order_id', $id)->get();
        $products = product::all();
        return view('orders.print-buy-price', ['order_products' => $order_products, 'products' => $products, 'order_custumer' => $order_custumer_info, 'order_id' => $id]);
    }

    public function custom_order($order_id, $product_id, $quantity)
    {
        $item = DB::table('order_items')
            ->where('product_id', '=', $product_id)
            ->where('order_id', '=', $order_id)
            ->delete();

        $get_order_total = DB::table('order_items')
            ->where('order_items.order_id', '=', $order_id)
            ->select(DB::raw('sum(total_price) as total_price'))
            ->first();
        $get_order_total = $get_order_total->total_price;

        DB::table('orders')
            ->where('id', $order_id)
            ->update(['order_total' => $get_order_total]);


        //update  stock _quantity

        DB::table('products')
            ->where('products.id', '=', $product_id)
            ->increment('products.stock_quantity', $quantity);

//    $stock=DB::table('products')
//    ->where('products.id', '=', $product_id)
//    ->select('products.stock_quantity as prev_stock')
//    ->first();
//    // "OLD STOCK = " .
//    $new_stock=$stock->prev_stock + $quantity;
//
//    DB::table('products')->where('id', $product_id)->update(
//    [
//    'stock_quantity' => $new_stock,
//    ]
//    );

        return redirect()->back();


    }


    public function custom_order_product(Request $request)
    {

        if ($request->product_id) {

            foreach ($request->product_id as $key => $v) {
                $find = DB::table('order_items')
                    ->where('order_id', '=', $request->id)
                    ->where('product_id', '=', $request->product_id[$key])
                    ->count();
                if ($find == 0) {
                    $pricedata = DB::table('products')
                        ->where('products.id', '=', $request->product_id[$key])
                        ->first();

                    $price = $pricedata->price - $pricedata->discount;
                    $data_arr = array(
                        'order_id' => $request->id,
                        'product_id' => $request->product_id[$key],
                        'unit_price' => $price,
                        'total_price' => $price * $request->quantity[$key],
                        'quantity' => $request->quantity[$key],
                        'customer_id' => $request->customer_id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    );
                    //array_push($data,$data_arr);
                    order_item::insert($data_arr);

                    //update stock

                    DB::table('products')
                        ->where('products.id', '=', $request->product_id[$key])
                        ->decrement('products.stock_quantity', $request->quantity[$key]);

//         $stock=DB::table('products')
//            ->where('products.id', '=', $request->product_id[$key])
//            ->select('products.stock_quantity as prev_stock')
//            ->first();
//          // "OLD STOCK = " .
//         $new_stock=$stock->prev_stock - $request->quantity[$key];
//
//         DB::table('products')->where('id', $request->product_id[$key])->update(
//         [
//            'stock_quantity' => $new_stock,
//         ]
//         );
                    //emd stock  update


                    $get_order_total = DB::table('order_items')
                        ->where('order_items.order_id', '=', $request->id)
                        ->select(DB::raw('sum(total_price) as total_price'))
                        ->first();
                    $get_order_total = $get_order_total->total_price;

                    DB::table('orders')
                        ->where('id', $request->id)
                        ->update(['order_total' => $get_order_total]);

                    // DB::table('orders')
                    //  ->where('id', $request->id)
                    // ->increment('order_total', $price*$request->quantity[$key]);

                    if ($request->delivery_dicsount > 0) {
                        DB::table('orders')->where('id', $request->id)->update(['coupon_discount_amount' => $request->delivery_dicsount, 'coupon' => 'ADDISC']);
                    }
                } else {
                    $request->session()->flash('status', ' The  product  is already  in  your  order');
                }
            }

        } else {

            if ($request->delivery_dicsount > 0) {
                DB::table('orders')->where('id', $request->id)->update(['coupon_discount_amount' => $request->delivery_dicsount, 'coupon' => 'ADDISC']);
            }
        }


        if (Auth::user()->role == 'admin') {
            return redirect('ad/order/' . $request->id);
        } elseif (Auth::user()->role == 'manager') {
            return redirect('pm/order/' . $request->id);
        } elseif (Auth::user()->role == 'author') {
            return redirect('au/order/' . $request->id);
        }

    }

    public function order_status(Request $request)
    {

        DB::beginTransaction();
        try {

            $order_id = $request->order_id;
            $order_total = $request->order_total;
            $delivery_man_id = $request->delivery_man_id;
            $date_time = now();

            if ($request->status == 'approve') {
                $get_order_total = DB::table('order_items')
                    ->where('order_items.order_id', $request->order_id)
                    ->select(DB::raw('sum(total_price) as get_order_total'))
                    ->first();

                $status = DB::table('orders')
                    ->where('id', $request->order_id)
                    ->update([
                        'order_total' => $get_order_total->get_order_total,
                        'delivery_man_id' => $delivery_man_id,
                        'approve_status' => 1,
                        'approve_date' => $date_time,
                        'updated_at' => $date_time,
                        'active_status' => 1,
                        'user_id' => Auth::id()
                    ]);


                DB::commit();
                $request->session()->flash('status', ' Order Status Updated successfully ');
                return redirect()->back();
            } elseif ($request->status == 'transit') {
                $status = DB::table('orders')->where('id', $request->order_id)->update(['delivery_man_id' => $delivery_man_id, 'transit_status' => 1, 'transit_date' => $date_time, 'updated_at' => $date_time, 'active_status' => 2, 'user_id' => Auth::id()]);

                $order_summary = DB::table('orders')
                    ->where('orders.id', '=', $order_id)
                    ->select('orders.order_total as  order_total', 'orders.delivery_charge as  delivery_charge', 'orders.coupon_discount_amount as  coupon_discount_amount')
                    ->first();

                $total_bill_amount = $order_summary->order_total + $order_summary->delivery_charge - $order_summary->coupon_discount_amount;

                if ($request->status == 'transit' && $request->sms == 'YES') {

                    //transit  user  info get
                    $delivery_person = DB::table('delivery_mans')
                        ->where('delivery_mans.id', '=', $delivery_man_id)
                        ->first();


                    $url = "http://66.45.237.70/api.php";
                    $number = '88' . $request->phone;
                    $text = "Your  order is  in Transport. Total payable amount: $total_bill_amount Taka. Delivery Man: $delivery_person->name Contact Number: $delivery_person->phone";
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
                DB::commit();
                $request->session()->flash('status', ' Order Status Updated successfully and SMS Sent to users');
                return redirect()->back();

            } elseif ($request->status == 'deivered') {

                $phone = $request->phone;
                $count_order_item = DB::table('order_items')
                    ->where('order_id', '=', $request->order_id)
                    ->where('product_id', '=', 37435)
                    ->count();
                if ($count_order_item == 1) {
                    $get_order_item = DB::table('order_items')
                        ->where('order_id', '=', $request->order_id)
                        ->where('product_id', '=', 37435)
                        ->first();

                    $count_cus = DB::table('water_customers')
                        ->where('phone', '=', $phone)
                        ->count();
                    if ($count_cus == 1) {
                        $customer_info = DB::table('water_customers')
                            ->where('phone', '=', $phone)
                            ->first();
                        $customer_id = $customer_info->id;
                        $month = date('m');
                        $year = date('Y');
                        $day = ltrim(date('d'), '0');
                        $day_key = 'd_' . $day . '_sell';

                        //check  if month  inserted
                        $user = DB::table('waters')
                            ->where('customer_id', '=', $customer_id)
                            ->where('year', '=', $year)
                            ->where('month', '=', $month)
                            ->count();
                        if ($user == 0) {
                            $values = array('customer_id' => $customer_id, 'year' => $year, 'month' => $month);
                            $res = DB::table('waters')->insert($values);
                        }

                        $update = DB::table('waters')
                            ->where('customer_id', $customer_id)
                            ->where('month', $month)
                            ->where('year', $year)
                            ->update([$day_key => $get_order_item->quantity]);

                        $status = DB::table('orders')->where('id', $request->order_id)->update(['delivery_man_id' => $delivery_man_id, 'delivered_status' => 1, 'delivered_date' => $date_time, 'updated_at' => $date_time, 'active_status' => 3, 'user_id' => Auth::id()]);
                        DB::commit();
                        $request->session()->flash('status', ' Order Status Updated successfully');
                        return redirect()->back();

                    } else {
                        DB::commit();
                        $request->session()->flash('status', 'Customer Not Found In water List');
                        return redirect()->back();
                    }
                } else {
                    $status = DB::table('orders')->where('id', $request->order_id)->update(['delivery_man_id' => $delivery_man_id, 'delivered_status' => 1, 'delivered_date' => $date_time, 'updated_at' => $date_time, 'active_status' => 3, 'user_id' => Auth::id()]);
                    DB::commit();
                    $request->session()->flash('status', ' Order Status Updated successfully');
                    return redirect()->back();
                }

            } elseif ($request->status == 'cancel') {
                $status = DB::table('orders')->where('id', $request->order_id)->update(['delivery_man_id' => $delivery_man_id, 'cancel_status' => 1, 'cancel_date' => $date_time, 'updated_at' => $date_time, 'active_status' => 4, 'user_id' => Auth::id()]);

                $order_products = DB::table('order_items')->where('order_id', $request->order_id)->get();

                //increment product  when cancel
                foreach ($order_products as $singleProduct) {

                    //update  stock _quantity
                    $stock = DB::table('products')
                        ->where('products.id', '=', $singleProduct->product_id)
                        ->select('products.stock_quantity as prev_stock')
                        ->first();
                    // "OLD STOCK = " .
                    $new_stock = $stock->prev_stock + $singleProduct->quantity;

                    DB::table('products')->where('id', $singleProduct->product_id)->update(
                        [
                            'stock_quantity' => $new_stock,
                        ]
                    );

                    //DB::table('products')->where('id', $singleProduct->product_id)->increment('stock_quantity', $singleProduct->quantity);
                }
                DB::commit();
                $request->session()->flash('status', ' Order Status Updated successfully');
                return redirect()->back();
            }

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), $e->getCode());
        }

    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

 public function cancel_order( )
    {
         
         $orders   =  DB::table('orders')
            ->where('orders.active_status', '=', 4)
            ->get();
         
           
         return view('report.cancel', ['orders' => $orders]);
    }

 public function daily_sale(Request $request)
    {
         
          $orders = DB::table('orders')
          ->where('orders.created_at', '>=', $request->date . ' 00:00:00')
            ->where('orders.created_at', '<=', $request->date . ' 23:59:59')
            ->get();
           
         return view('report.daily', ['orders' => $orders]);
    }

    public function monthly_sale(Request $request)
    {
        
          $orders = $orders = DB::table('orders')
    ->whereMonth('orders.created_at', '=', $request->month)
    ->whereYear('orders.created_at', '=', $request->year)
    ->get();
          
         return view('report.monthly', ['orders' => $orders]);
    }

    public function manager_index()
    {

        $check_new_order = DB::table('orders')
            ->where('orders.active_status', '=', 0)
            ->count();


        $today_date = date('Y-m-d');

        $allproducts = DB::table('products')
            ->get();

        $today_orders = DB::table('orders')->select(DB::raw('COUNT(*) as `count`'))
            ->where('orders.delivered_date', '>=', $today_date . ' 00:00:00')
            ->where('orders.delivered_date', '<=', $today_date . ' 23:59:59')
            ->where('orders.active_status', '=', 3)
            ->get();

        //for manager  dashboard

        $products = DB::table('products')
            ->orderBy('products.stock_quantity', 'ASC')
            ->where('products.status', '=', 1)
            ->limit(10)
            ->get();
        $allproducts = DB::table('products')
            ->get();
        $orders = DB::table('orders')
            ->join('users', 'orders.customer_id', '=', 'users.id')
            ->select('orders.*', 'orders.id as  order_id', 'users.name as  name', 'users.phone as  phone')
            ->orderBy('orders.id', 'DESC')
            ->get();


        $sales = DB::table('orders')
            ->where('orders.active_status', '=', 3)
            ->select(DB::raw('DATE(delivered_date) as date'), DB::raw('sum(order_total) as order_total'), DB::raw('sum(delivery_charge) as delivery_charge'), DB::raw('sum(coupon_discount_amount) as coupon_discount_amount'))
            ->groupBy(DB::raw("DATE(delivered_date)"))
            ->get();


        $totalDays = date("t");
        $arr = range(1, $totalDays);
        $y = [];
        $z = [];
        foreach ($arr as $ar) {
            foreach ($sales as $sale) {
                $thisdate = date('d', strtotime($sale->date));
                if ($thisdate == $ar) {
                    array_push($z, [$thisdate]);
                    array_push($y, [$sale->order_total + $sale->delivery_charge - $sale->coupon_discount_amount]);
                }
            }
        }

        $sales_summary = DB::table('orders')
            //->whereDate('delivered_date', '=', date('Y-m-d'))
            ->where('delivered_date', '>=', $today_date . ' 00:00:00')
            ->where('delivered_date', '<=', $today_date . ' 23:59:59')
            ->where('orders.active_status', '=', 3)
            ->select(DB::raw('sum(order_total) as order_total'), DB::raw('sum(delivery_charge) as delivery_charge'),
                DB::raw('sum(coupon_discount_amount) as coupon_discount_amount'))
            ->first();


        $delivered_sales_id = DB::table('orders')
            ->where('orders.active_status', '=', 3)
            ->select('orders.id as order_id')
            ->get();

        $total_buy_amount = DB::table('orders')
            //->whereDate('delivered_date', '=', date('Y-m-d'))
            ->where('delivered_date', '>=', $today_date . ' 00:00:00')
            ->where('delivered_date', '<=', $today_date . ' 23:59:59')
            ->where('active_status', '=', 3)
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->select(DB::raw('sum(order_items.total_buy_price) as total_buy_price'))
            ->first();


        //$today_date=date('Y-m-d');
        $last_date = date("Y-m-t");
        $first_date = date('Y-m-01');
        $check_if_not_price_add = DB::table('orders')
            ->where('delivered_date', '>=', $first_date . ' 00:00:00')
            ->where('delivered_date', '<=', $last_date . ' 23:59:59')
            ->where('active_status', '=', 3)
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('order_items.total_buy_price', '<=', 0)
            ->select('orders.id as pending_id')
            ->get();
//->count();

        $total_avaiable_stock_amount = DB::table('products')
            ->where('products.buy_price', '>', 0)
            ->where('products.status', '=', 1)
            ->where('products.stock_quantity', '>', 0)
            ->select(DB::raw('sum(products.buy_price*products.stock_quantity) as total_avaiable_stock_amount'))
//            ->get()
            ->first();

        //Due counting

        $incomplete_orders = DB::table('orders')
            ->whereIn('active_status', [1, 2])
            ->select('id')->get()->toArray();
        //get order item
        $total_buy_price = 0;
//        foreach($incomplete_orders as $order){
//            $order_items = DB::table('order_items')
//                ->join('products', 'products.id', '=', 'order_items.product_id')
//                ->where('order_items.order_id','=', $order->id)
//                ->select('order_items.quantity','products.buy_price')->get()->toArray();
//
//            foreach ($order_items as $item){
//                if( $item->buy_price ){
//                    $buyprice = $item->buy_price * $item->quantity;
//                    $total_buy_price+= $buyprice;
//                }
//            }
//
//        }
        //dd($total_buy_price);
        foreach ($incomplete_orders as $order) {


            $order_items = DB::table('order_items')
                ->where('order_items.order_id', '=', $order->id)
                ->select('order_items.total_buy_price')->get()->toArray();


            foreach ($order_items as $item) {
                if ($item->total_buy_price) {
                    $buyprice = $item->total_buy_price;
                    $total_buy_price += $buyprice;
                }
            }

        }
        $total_due_amount = DB::table('due_sales')
            ->select(DB::raw('sum(amount) as amount'))
            ->first();
        $total_due_paid = DB::table('collect_due_payment')
            ->select(DB::raw('sum(pay_amount) as pay_amount'))
            ->first();
        $waiting_stock_money = DB::table('waiting_stocks')
            ->select(DB::raw('sum(total_price) as total_price'))
            ->first();

        $given_money = DB::table('stock_money')
            ->where('type', '=', "money-minus")
            ->select(DB::raw('sum(amount) as given_money'))
            ->first();
        $taken_money = DB::table('stock_money')
            ->where('type', '=', "money-plus")
            ->select(DB::raw('sum(amount) as taken_money'))
            ->first();

        $daily_summary = DB::table('daily_summary')
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->get();

        $today_added_products_in_stock = DB::table('product_stocks')
            ->whereDate('created_at', DB::raw('CURDATE()'))
            ->get();

        $deposit_requests = DB::table('deposit_requests')
            ->where('status', '=', 0)
            ->count();

        $deposits = DB::table('deposits')
            ->select(DB::raw('sum(amount) as total_amount'))
            ->first();
        $purchase_deposit_amount = DB::table('due_purchase_history')
            ->select(DB::raw('sum(amount) as amount'))
            ->first();

        $shop_taken_money = DB::table('shop_investments')
            ->where('type', '=', "money-minus")
            ->select(DB::raw('sum(amount) as taken_money'))
            ->first();
        $shop_given_money = DB::table('shop_investments')
            ->where('type', '=', "money-plus")
            ->select(DB::raw('sum(amount) as given_money'))
            ->first();
//        $damage_total=DB::table('damages')
//            ->where('is_deleted', '=', 0)
//            ->sum(DB::raw('total_price'));
        $damage_total = DB::table('damages')
            ->where('is_deleted', '=', 0)
            ->sum(DB::raw('total_price'));

        $today_water_delivered_orders = DB::table('orders')->select(DB::raw('COUNT(*) as `count`'))
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.delivered_date', '>=', $today_date . ' 00:00:00')
            ->where('orders.delivered_date', '<=', $today_date . ' 23:59:59')
            ->where('orders.active_status', '=', 3)
            ->where('order_items.product_id', '=', 37435)
            ->select(DB::raw('sum(quantity) as quantity'))
            ->first();

        return view('home', [
            'today_water_delivered_orders' => $today_water_delivered_orders,
            'damage_total' => $damage_total,
            'shop_given_stock_money' => $shop_given_money->given_money,
            'shop_taken_stock_money' => $shop_taken_money->taken_money,
            'sales' => $sales,
            'remaining_deposit_money' => $deposits->total_amount - $purchase_deposit_amount->amount,
            'deposit_requests' => $deposit_requests,
            'today_added_products_in_stock' => $today_added_products_in_stock,
            'orders' => $orders,
            'products' => $products,
            'allproducts' => $allproducts,
            'sales_summary' => $sales_summary,
            'total_buy_amount' => $total_buy_amount,
            'minus_from_stock_amount' => $given_money->given_money,
            'plus_for_stock_amount' => $taken_money->taken_money,
            'total_orders' => $today_orders[0]->count,
            'check_new_order' => $check_new_order,
            'remaining_stock_amount' => $total_avaiable_stock_amount,
            'check_if_not_price_add' => $check_if_not_price_add,
            'total_due_amount' => $total_due_amount,
            'total_due_paid' => $total_due_paid,
            'waiting_stock_money' => $waiting_stock_money,
            'incomplete_order_buy_price' => $total_buy_price,
            'daily_summary' => $daily_summary,
        ]);


    }


    public function index()
    {

        $check_new_order = DB::table('orders')
            ->where('orders.active_status', '=', 0)
            ->count();


        $today_date = date('Y-m-d');
//        $today_date='2022-02-18';

        //if( Auth::user()->role ="admin"){

        //}


        //$sales=DB::table('orders')
        // ->where('orders.active_status', '=',3)
        // ->where('orders.delivered_date', '>=',  $today_date.' 00:00:00')
        // ->where('orders.delivered_date', '<=', $today_date.' 23:59:59')
        // ->select(DB::raw('sum(order_total) as order_total'),DB::raw('sum(delivery_charge) as delivery_charge'),DB::raw('sum(coupon_discount_amount) as coupon_discount_amount'))
        // ->first();


       
        $today_water_delivered_orders = DB::table('orders')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.delivered_date', '>=', $today_date . ' 00:00:00')
            ->where('orders.delivered_date', '<=', $today_date . ' 23:59:59')
            ->where('orders.active_status', '=', 3)
            ->where('order_items.product_id', '=', 37435)
            ->select(DB::raw('sum(quantity) as quantity'))
            ->first();
        $today_water_delivered_orders_count = DB::table('orders')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.delivered_date', '>=', $today_date . ' 00:00:00')
            ->where('orders.delivered_date', '<=', $today_date . ' 23:59:59')
            ->where('orders.active_status', '=', 3)
            ->where('order_items.product_id', '=', 37435)
            ->count('order_items.order_id');

        $today_grocery_delivered_orders = DB::table('orders')->select(DB::raw('COUNT(orders.id) as `count`'))
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.delivered_date', '>=', $today_date . ' 00:00:00')
            ->where('orders.delivered_date', '<=', $today_date . ' 23:59:59')
            ->where('orders.active_status', '=', 3)
            ->where('order_items.product_id', '=', 37435)
            ->whereNotIn('order_items.product_id', [37435])
            ->groupBy(DB::raw("orders.id"))
            ->get();

        $products = DB::table('products')
            ->orderBy('products.stock_quantity', 'ASC')
            ->where('products.status', '=', 1)
            ->limit(10)
            ->get();
        $allproducts = DB::table('products')
            ->get();
        $shop_allproducts = DB::table('shop_products')
            ->get();

        $orders = DB::table('orders')
            ->join('users', 'orders.customer_id', '=', 'users.id')
            ->select('orders.*', 'orders.id as  order_id', 'users.name as  name', 'users.phone as  phone')
            ->orderBy('orders.id', 'DESC')
            ->get();


        $sales = DB::table('orders')
            ->where('orders.active_status', '=', 3)
            ->select(DB::raw('DATE(delivered_date) as date'), DB::raw('sum(order_total) as order_total'), DB::raw('sum(delivery_charge) as delivery_charge'), DB::raw('sum(coupon_discount_amount) as coupon_discount_amount'))
            ->groupBy(DB::raw("DATE(delivered_date)"))
            ->get();
     
        $totalDays = date("t");
        $arr = range(1, $totalDays);
        $y = [];
        $z = [];
        foreach ($arr as $ar) {
            foreach ($sales as $sale) {
                $thisdate = date('d', strtotime($sale->date));
                if ($thisdate == $ar) {
                    array_push($z, [$thisdate]);
                    array_push($y, [$sale->order_total + $sale->delivery_charge - $sale->coupon_discount_amount]);
                }
            }
        }
 
        $sales_summary = DB::table('orders')
            ->where('orders.active_status', '=', 3)
            ->select(DB::raw('sum(order_total) as order_total'), DB::raw('sum(delivery_charge) as delivery_charge'),
                DB::raw('sum(coupon_discount_amount) as coupon_discount_amount'))
            ->first();


        $delivered_sales_id = DB::table('orders')
            ->where('orders.active_status', '=', 3)
            ->select('orders.id as order_id')
            ->get();


        //$total_buy_amount = DB::table('order_items')
        //->whereIn('order_id', [21,23,24])

        //->get();
        //return $total_buy_amount;


        $total_buy_amount = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.active_status', '=', 3)
            ->select(DB::raw('sum(order_items.total_buy_price) as total_buy_price'))
            ->first();

        $total_avaiable_stock_amount = DB::table('products')
            ->where('products.buy_price', '>', 0)
            ->where('products.stock_quantity', '>', 0)
            ->where('products.status', '=', 1)
            ->select(DB::raw('sum(products.buy_price*products.stock_quantity) as total_avaiable_stock_amount'))
            ->get()
            ->first();


        $sales_start_date = DB::table('orders')
            ->where('orders.active_status', '=', 3)
            ->select('orders.created_at as sales_start_date')
            ->first();

        //count if not buy price added
        $last_date = date("Y-m-t");
        $first_date = date('Y-m-01');

//$today_date=date('Y-m-d');
        $check_if_not_price_add = DB::table('orders')
            ->where('delivered_date', '>=', $first_date . ' 00:00:00')
            ->where('delivered_date', '<=', $last_date . ' 23:59:59')
            ->where('active_status', '=', 3)
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('order_items.total_buy_price', '<=', 0)
            ->select('orders.id as pending_id')
            ->get();
//->count();
//expected stock  money calculate
        $given_money = DB::table('stock_money')
            ->where('type', '=', "money-minus")
            ->select(DB::raw('sum(amount) as given_money'))
            ->first();
        $taken_money = DB::table('stock_money')
            ->where('type', '=', "money-plus")
            ->select(DB::raw('sum(amount) as taken_money'))
            ->first();


        $summary = DB::table('stock_money')
            ->join('users', 'users.id', '=', 'stock_money.user_id')
            ->select('stock_money.amount', 'stock_money.type', 'stock_money.purpose', 'stock_money.date', 'stock_money.purpose', 'stock_money.created_at', 'users.name')
            ->orderBy('stock_money.id', 'desc')->take(4)->get();

        $vendor_request_count = DB::table('vendor_requests')
            ->where('vendor_requests.status', '=', 0)
            ->count();

        $total_due_amount = DB::table('due_sales')
            ->select(DB::raw('sum(amount) as amount'))
            ->first();
        $total_due_paid = DB::table('collect_due_payment')
            ->select(DB::raw('sum(pay_amount) as pay_amount'))
            ->first();
        $waiting_stock_money = DB::table('waiting_stocks')
            ->select(DB::raw('sum(total_price) as total_price'))
            ->first();


        $today_date = date('Y-m-d');
//        $today_expense = DB::table('expenses')
//            ->where('created_at', '>=', $today_date . ' 00:00:00')
//            ->where('created_at', '<=', $today_date . ' 23:59:59')
//            ->join('users', 'users.id', '=', 'expenses.user_id')
//            ->select('expenses.amount','expenses.purpose','expenses.created_at','users.name')
//            ->get();
//   dd($today_expense);

        //Due counting

        $incomplete_orders = DB::table('orders')
            ->whereIn('active_status', [1, 2])
            ->select('id')->get()->toArray();
        //get order item
        $total_buy_price = 0;
        foreach ($incomplete_orders as $order) {
            //real stock  product  buy price
//            $order_items = DB::table('order_items')
//                ->join('products', 'products.id', '=', 'order_items.product_id')
//                ->where('order_items.order_id','=', $order->id)
//                ->select('order_items.quantity','products.buy_price')->get()->toArray();
//            foreach ($order_items as $item){
//                if( $item->buy_price ){
//                    $buyprice = $item->buy_price * $item->quantity;
//                    $total_buy_price+= $buyprice;
//                }
//            }

            $order_items = DB::table('order_items')
                ->where('order_items.order_id', '=', $order->id)
                ->select('order_items.total_buy_price')->get()->toArray();


            foreach ($order_items as $item) {
                if ($item->total_buy_price) {
                    $buyprice = $item->total_buy_price;
                    $total_buy_price += $buyprice;
                }
            }

        }
        $daily_summary = DB::table('daily_summary')
            ->join('users', 'users.id', '=', 'daily_summary.user_id')
            ->select('daily_summary.*', 'users.name')
            ->orderBy('daily_summary.id', 'DESC')
            ->limit(5)
            ->get();

        $today_added_products_in_stock = DB::table('product_stocks')
            ->whereDate('created_at', DB::raw('CURDATE()'))
            ->get();
        $shop_today_added_products_in_stock = DB::table('shop_product_stocks')
            ->whereDate('created_at', DB::raw('CURDATE()'))
            ->get();
        $deposit_requests = DB::table('deposit_requests')
            ->where('status', '=', 0)
            ->count();


        $deposits = DB::table('deposits')
            ->select(DB::raw('sum(amount) as total_amount'))
            ->first();
        $purchase_deposit_amount = DB::table('due_purchase_history')
            ->select(DB::raw('sum(amount) as amount'))
            ->first();

//shop  money calculate
        $shop_taken_money = DB::table('shop_investments')
            ->where('type', '=', "money-minus")
            ->select(DB::raw('sum(amount) as taken_money'))
            ->first();
        $shop_given_money = DB::table('shop_investments')
            ->where('type', '=', "money-plus")
            ->select(DB::raw('sum(amount) as given_money'))
            ->first();
        $shop_total_avaiable_stock_amount = DB::table('shop_products')
            ->where('shop_products.buy_price', '>', 0)
            ->where('shop_products.stock_quantity', '>', 0)
            ->where('shop_products.status', '=', 1)
            ->select(DB::raw('sum(shop_products.buy_price*shop_products.stock_quantity) as total_avaiable_stock_amount'))
            ->get()
            ->first();


        $shop_incomplete_orders = DB::table('shop_orders')
            ->whereIn('active_status', [1, 2])
            ->select('id')->get()->toArray();
        //get order item
        $shop_total_buy_price = 0;
        foreach ($shop_incomplete_orders as $order) {
            $order_items = DB::table('shop_order_items')
                ->where('shop_order_items.order_id', '=', $order->id)
                ->select('shop_order_items.total_buy_price')->get()->toArray();

            foreach ($order_items as $item) {
                if ($item->total_buy_price) {
                    $buyprice = $item->total_buy_price;
                    $shop_total_buy_price += $buyprice;
                }
            }

        }
        $shop_sales_summary = DB::table('shop_orders')
            ->where('shop_orders.active_status', '=', 3)
            ->select(DB::raw('sum(order_total) as order_total'), DB::raw('sum(delivery_charge) as delivery_charge'),
                DB::raw('sum(coupon_discount_amount) as coupon_discount_amount'))
            ->first();
        $shop_total_buy_amount = DB::table('shop_orders')
            ->join('shop_order_items', 'shop_orders.id', '=', 'shop_order_items.order_id')
            ->where('shop_orders.active_status', '=', 3)
            ->select(DB::raw('sum(shop_order_items.total_buy_price) as total_buy_price'))
            ->first();

        $damage_total = DB::table('damages')
            ->where('is_deleted', '=', 0)
            ->sum(DB::raw('total_price'));

 $today_orders = DB::table('orders')->select(DB::raw('COUNT(*) as `count`'))
            ->get();
 
        return view('home', [
            //'today_expense' => $today_expense,
            'damage_total' => $damage_total,
            'shop_total_profit' => $shop_sales_summary->order_total + $shop_sales_summary->delivery_charge - $shop_sales_summary->coupon_discount_amount - $shop_total_buy_amount->total_buy_price,
            'shop_incomplete_order_total_buy_price' => $shop_total_buy_price,
            'shop_given_stock_money' => $shop_given_money->given_money,
            'shop_taken_stock_money' => $shop_taken_money->taken_money,
            'shop_total_avaiable_stock_amount' => $shop_total_avaiable_stock_amount->total_avaiable_stock_amount,
            'stock_summary' => $summary,
            'remaining_deposit_money' => $deposits->total_amount - $purchase_deposit_amount->amount,
            'deposit_requests' => $deposit_requests,
            'allproducts' => $allproducts,
            'shop_allproducts' => $shop_allproducts,
            'today_added_products_in_stock' => $today_added_products_in_stock,
            'shop_today_added_products_in_stock' => $shop_today_added_products_in_stock,
            'incomplete_order_buy_price' => $total_buy_price,
            'total_due_amount' => $total_due_amount,
            'waiting_stock_money' => $waiting_stock_money,
            'total_due_paid' => $total_due_paid,
            'minus_from_stock_amount' => $given_money->given_money,
            'plus_for_stock_amount' => $taken_money->taken_money,
            'sales' => $sales,
            'orders' => $orders,
            'products' => $products,
            'sales_summary' => $sales_summary,
            'total_buy_amount' => $total_buy_amount,
            'sales_start_date' => $sales_start_date,
            'total_orders' => $today_orders[0]->count,
            'remaining_stock_amount' => $total_avaiable_stock_amount,
            'check_new_order' => $check_new_order,
            'check_if_not_price_add' => $check_if_not_price_add,
            'vendor_request_count' => $vendor_request_count,
            'daily_summary' => $daily_summary,
            'today_water_delivered_orders' => $today_water_delivered_orders,
            'count_today_water_delivered_orders' => $today_water_delivered_orders_count

        ]);
    }

    public function sales_calculation($start_date, $end_date)
    {
        $new_startDate = $start_date . ' 00:00:00';
        $new_endDate = $end_date . ' 23:59:59';

        $sales_data = DB::table('orders')
            ->selectRaw("sum(order_total) as order_total, sum(delivery_charge) as delivery_charge,sum(coupon_discount_amount) as coupon_discount_amount ")
            ->where('delivered_date', '>=', $new_startDate)
            ->where('delivered_date', '<=', $new_endDate)
            ->where('active_status', '=', 3)
            ->first();


        $buy_amount = DB::table('orders')
            ->where('delivered_date', '>=', $new_startDate)
            ->where('delivered_date', '<=', $new_endDate)
            ->where('active_status', '=', 3)
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->select(DB::raw('sum(order_items.total_buy_price) as total_buy_price'))
            ->first();


        return response()->json([
            'sales_data' => $sales_data,
            'buy_amount' => $buy_amount
        ]);

    }


    public function delete_childcategory(Request $request)
    {
        $id = $request->id;
        DB::table('child_sub_cats')
            ->where('id', '=', $id)
            ->delete();
        return redirect()->back();

    }
    public function delete_subcategory(Request $request)
    {
        $id = $request->id;
        DB::table('sub_categories')
            ->where('id', '=', $id)
            ->delete();
        return redirect()->back();

    }
    public function delete_category(Request $request)
    {
        $id = $request->id;
        DB::table('categories')
            ->where('id', '=', $id)
            ->delete();
        return redirect()->back();

    }


    public function other_income_calculation($start_date, $end_date)
    {
        $new_startDate = date("yy-m-d", strtotime($start_date));
        $new_endDate = date("yy-m-d", strtotime($end_date));


        $income_amount = DB::table('other_incomes')
            ->where('created_at', '>=', $new_startDate)
            ->where('created_at', '<=', $new_endDate)
            ->select(DB::raw('sum(other_incomes.amount) as amount'))
            ->first();


        return response()->json([
            'income_amount' => $income_amount
        ]);

    }


    public function add_medicine()
    {

        $category = Category::all();
        $sub_category = sub_category::all();
        $child_sub_category = child_sub_cats::all();
        $units = unit::all();
        $brands = brand::all();
        return view('medicines.add-medicine', ['units' => $units, 'category' => $category, 'sub_category' => $sub_category, 'brands' => $brands, 'child_sub_category' => $child_sub_category]);

    }


    public function add_product()
    {
        $category = Category::all();
        $sub_category = sub_category::all();
        $child_sub_category = child_sub_cats::all();
        $units = unit::all();
        $brands = brand::all();
        return view('products.add-product', ['units' => $units, 'category' => $category, 'sub_category' => $sub_category, 'brands' => $brands, 'child_sub_category' => $child_sub_category]);
    }

    public function vendor_new_product()
    {
        $category = Category::all();
        $sub_category = sub_category::all();
        $child_sub_category = child_sub_cats::all();
        $units = unit::all();
        $brands = brand::all();
        return view('vendor.products.add-product', ['units' => $units, 'category' => $category, 'sub_category' => $sub_category, 'brands' => $brands, 'child_sub_category' => $child_sub_category]);
    }

    public function vendor_create_product(Request $request)
    {


        if ($request->sub_category_id) {
            $sub_category_id_list = implode(",", $request->sub_category_id);
        } else {
            $sub_category_id_list = '';
        }
        if ($request->child_sub_category_id) {
            $child_sub_category_id_list = implode(",", $request->child_sub_category_id);
        } else {
            $child_sub_category_id_list = '';
        }

        $userId = Auth::id();
        $product = new product();
        $slug = Str::slug($request->name, '-');
        $data['data'] = DB::table('products')->where('slug', $slug)->first();
        if (count($data) > 0) {
            $slug = $slug . '-' . rand(1, 300);
        } else {
            $slug = $slug;
        }
        //featured  image
        $f_image = $request->file('featured_img');
        if ($f_image != '') {
            $image = $f_image;
            //unique  file name
            $filename = time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            //Image::make($image_resize)->resize(400, null, function($constraint) {
            //  $constraint->aspectRatio();
            //});
            $image_resize->save('uploads/products/' . $filename);
            $product->featured_image = $filename;
        } else {
            $product->featured_image = '';
        }

        $gp_image = $request->gallery_img;
        if ($gp_image != '') {
            $count = count($gp_image);
            //gallery image
            for ($n = 0; $n < $count; $n++) {
                $a = $n + 1;
//            $gphoto = $gp_image[$n];
//           $photo_name = time().rand(1, 100000).'.'.$gphoto->getClientOriginalExtension();
//           $gphoto->move('uploads/gallery_images',$photo_name);

                $image = $gp_image[$n];;
                //unique  file name
                $filename = time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();
                $image_resize = Image::make($image->getRealPath());
                //Image::make($image_resize)->resize(400, null, function($constraint) {
                //  $constraint->aspectRatio();
                //});
                $image_resize->save('uploads/products/' . $filename);

                $db_field_name = "gp_image_" . $a;
                $product->$db_field_name = $filename;
            }
        }

        $product->name = $request->name;
        $product->name_bn = $request->name_bn;
        $product->tags = $request->tags;
        $product->brand_id = $request->brand_id;
        $product->description = $request->description;
        $product->slug = $slug;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $sub_category_id_list;
        $product->child_sub_cats_id = $child_sub_category_id_list;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->unit_quantity = $request->unit_quantity;
        $product->stock_quantity = $request->stock_quantity;
        $product->unit = $request->unit;
        $product->description = $request->description;
        $product->status = 0;
        $product->user_id = $userId;
        $product->save();
        $request->session()->flash('status', ' New Product  added successfully!');
        return redirect('ve/add-product');

    }

    public function vendor_product_list()
    {
        $userId = Auth::id();
        $products = DB::table('products as p')
            ->join('categories as C', 'p.category_id', '=', 'C.id')
            ->join('sub_categories as SC', 'p.sub_category_id', '=', 'SC.id')
            //->join('child_sub_cats as CC','p.child_sub_cats_id','=','CC.id')
            ->select('p.id', 'p.name', 'p.slug', 'p.price', 'p.discount', 'p.unit_quantity', 'p.stock_quantity', 'p.featured_image', 'p.gp_image_1', 'p.gp_image_2', 'p.gp_image_3', 'p.gp_image_4', 'p.unit', 'C.cat_name', 'SC.sub_cat_name')
            ->where('p.user_id', '=', $userId)
            ->get();
        return view('vendor.products.products', ['products' => $products]);
    }


    public function create_medicine(Request $request)
    {


        $userId = Auth::id();
        $product = new product();
        $slug = Str::slug($request->name, '-');
        $data['data'] = DB::table('products')->where('slug', $slug)->first();
        if (count($data) > 0) {
            $slug = $slug . '-' . rand(1, 300);
        } else {
            $slug = $slug;
        }
        //featured  image
        $f_image = $request->file('featured_img');
        if ($f_image != '') {
            $image = $f_image;
            //unique  file name
            $filename = time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            //Image::make($image_resize)->resize(400, null, function($constraint) {
            //  $constraint->aspectRatio();
            //});
            $image_resize->save('uploads/products/' . $filename);
            $product->featured_image = $filename;
        } else {
            $product->featured_image = '';
        }
        if ($request->sub_category_id) {
            $sub_category_id_list = implode(",", $request->sub_category_id);
        } else {
            $sub_category_id_list = '';
        }
        $product->name = $request->name;
        $product->name_bn = $request->name_bn;
        $product->tags = $request->tags;
        $product->brand_id = $request->brand_id;
        $product->description = $request->description;
        $product->slug = $slug;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $sub_category_id_list;
        $product->price = $request->price;
        $product->buy_price = $request->buy_price;
        $product->discount = $request->discount;
        $product->unit_quantity = $request->unit_quantity;
        $product->stock_quantity = $request->stock_quantity;
        $product->unit = $request->unit;
        $product->description = $request->description;
        $product->status = 1;
        $product->user_id = $userId;

        $product->generic_name = $request->generic_name;
        $product->strength = $request->strength;
        $product->dosages_description = $request->dosages_description;
        $product->use_for = $request->use_for;
        $product->DAR = $request->DAR;

        $product->save();
        $request->session()->flash('status', ' New Medicine  added successfully!');
        return redirect()->back();
    }


    public function create_product(Request $request)
    {

        if ($request->sub_category_id) {
            $sub_category_id_list = implode(",", $request->sub_category_id);
        } else {
            $sub_category_id_list = '';
        }
        if ($request->child_sub_category_id) {
            $child_sub_category_id_list = implode(",", $request->child_sub_category_id);
        } else {
            $child_sub_category_id_list = '';
        }

        $userId = Auth::id();
        $product = new product();
        $slug = Str::slug($request->name, '-');
        $data['data'] = DB::table('products')->where('slug', $slug)->first();
        if (count($data) > 0) {
            $slug = $slug . '-' . rand(1, 300);
        } else {
            $slug = $slug;
        }
        //featured  image
        $f_image = $request->file('featured_img');
        if ($f_image != '') {
            $image = $f_image;
            //unique  file name
            $filename = time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            //Image::make($image_resize)->resize(400, null, function($constraint) {
            //  $constraint->aspectRatio();
            //});
            $image_resize->save('uploads/products/' . $filename);
            $product->featured_image = $filename;
        } else {
            $product->featured_image = '';
        }

        $gp_image = $request->gallery_img;
        if ($gp_image != '') {
            $count = count($gp_image);
            //gallery image
            for ($n = 0; $n < $count; $n++) {
                $a = $n + 1;
//            $gphoto = $gp_image[$n];
//           $photo_name = time().rand(1, 100000).'.'.$gphoto->getClientOriginalExtension();
//           $gphoto->move('uploads/gallery_images',$photo_name);

                $image = $gp_image[$n];;
                //unique  file name
                $filename = time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();
                $image_resize = Image::make($image->getRealPath());
                //Image::make($image_resize)->resize(400, null, function($constraint) {
                //  $constraint->aspectRatio();
                //});
                $image_resize->save('uploads/products/' . $filename);

                $db_field_name = "gp_image_" . $a;
                $product->$db_field_name = $filename;
            }
        }

        $product->name = $request->name;
        $product->name_bn = $request->name_bn;
        $product->tags = $request->tags;
        $product->brand_id = $request->brand_id;
        $product->description = $request->description;
        $product->slug = $slug;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $sub_category_id_list;

        $product->child_sub_cats_id = $child_sub_category_id_list;
        $product->price = $request->price;
        $product->buy_price = $request->buy_price;
        $product->discount = $request->discount;
        $product->unit_quantity = $request->unit_quantity;
        $product->stock_quantity = $request->stock_quantity;
        $product->unit = $request->unit;
        $product->description = $request->description;
        $product->real_stock = 0;
        $product->status = $request->status;
        $product->user_id = $userId;
        $product->save();
        $request->session()->flash('status', ' New Product  added successfully!');

        return redirect()->back();
//        if (Auth::user()->role == 'admin') {
//            return redirect('ad/products');
//        } elseif (Auth::user()->role == 'manager') {
//            return redirect('pm/products');
//         } elseif (Auth::user()->role == 'author') {
//        return redirect('au/add-product');
//        }

    }

    public function assign_real_stock()
    {

        $products = DB::table('products as p')
            ->join('categories as C', 'p.category_id', '=', 'C.id')
            ->join('sub_categories as SC', 'p.sub_category_id', '=', 'SC.id')
            ->where('p.real_stock', '=', 0)
            ->select('p.id', 'p.name', 'p.slug', 'p.price', 'p.discount', 'p.unit_quantity', 'p.stock_quantity', 'p.featured_image', 'p.gp_image_1', 'p.gp_image_2', 'p.gp_image_3', 'p.gp_image_4', 'p.unit', 'C.cat_name', 'SC.sub_cat_name')
            ->get();
        return view('products.real-stock-product', ['products' => $products]);
    }

    public function update_real_stock($id)
    {
        DB::table('products')->where('id', $id)
            ->update(['real_stock' => 1,
            ]);

        return redirect('ad/assign-real-stock');


    }


    public function inactive_update(Request $request)
    {
        DB::table('products')->where('id', $request->id)
            ->update(['status' => 1,
            ]);
        //$request->session()->flash('status', 'Product Updated successfully!');

        if (Auth::user()->role == 'admin') {
            return redirect('ad/inactive');
        } elseif (Auth::user()->role == 'manager') {
            return redirect('pm/inactive');
        }


    }

    public function update_product(Request $request)
    {


        if ($request->sub_category_id) {
            $sub_category_id_list = implode(",", $request->sub_category_id);
        } else {
            $sub_category_id_list = '';
        }
        if ($request->child_sub_cats_id) {
            $child_sub_category_id_list = implode(",", $request->child_sub_cats_id);
        } else {
            $child_sub_category_id_list = '';
        }
        $name = $request->name;
        $name_bn = $request->name_bn;
        $price = $request->price;
        $discount = $request->discount;
        $quantity = $request->unit_quantity;
//        $is_featured = $request->is_featured;
        if ($request->stock_quantity) {
            $stock_quantity = $request->stock_quantity;
        } else {
            $stock_quantity = 0;
        }
        if ($request->buy_price) {
            $buy_price = $request->buy_price;
        } else {
            $buy_price = 0;
        }
        $unit = $request->unit;
        $status = $request->status;
        $category_id = $request->category_id;
        $is_featured = $request->is_featured;
        $sub_category_id = $sub_category_id_list;
        $child_sub_cats_id = $child_sub_category_id_list;
        $description = $request->description;
        $brand_id = $request->brand_id;
        $tags = $request->tags;

        $f_image = $request->file('featured_img');
        $gp_image_1 = $request->file('gp_image_1');
        $gp_image_2 = $request->file('gp_image_2');
        $gp_image_3 = $request->file('gp_image_3');
        $gp_image_4 = $request->file('gp_image_4');

        $old_f_image = $request->old_featured_img;
        $old_gp_image_1 = $request->old_gp_image_1;
        $old_gp_image_2 = $request->old_gp_image_2;
        $old_gp_image_3 = $request->old_gp_image_3;
        $old_gp_image_4 = $request->old_gp_image_4;

        if ($f_image != '') {

            $image = $f_image;
            //unique  file name
            $filename = time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            // Image::make($image_resize)->resize(400, null, function($constraint) {
            //   $constraint->aspectRatio();
            //});
            $image_resize->save('uploads/products/' . $filename);

            //img  file  code  end
            $f_img_name = $filename;
        } else {
            $f_img_name = $old_f_image;
        }

        if ($gp_image_1 != '') {

            $image = $gp_image_1;
            //img  file  code  START
            //unique  file name
            $filename = time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            //Image::make($image_resize)->resize(400, null, function($constraint) {
            //  $constraint->aspectRatio();
            //});
            $image_resize->save('uploads/products/' . $filename);
            //img  file  code  end
            $gp_img_name_1 = $filename;

        } else {
            $gp_img_name_1 = $old_gp_image_1;
        }

        if ($gp_image_2 != '') {
//            $g_img_name_2 = time().rand(1, 100000).'.'.$gp_image_2->getClientOriginalExtension();
//            $gp_image_2->move('uploads/gallery_images',$g_img_name_2);
//            $gp_img_name_2 = $g_img_name_2;

            $image = $gp_image_2;
            //unique  file name
            //img  file  code  START
            //unique  file name
            $filename = time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            //Image::make($image_resize)->resize(400, null, function($constraint) {
            //  $constraint->aspectRatio();
            //});
            $image_resize->save('uploads/products/' . $filename);
            //img  file  code  end
            $gp_img_name_2 = $filename;

        } else {
            $gp_img_name_2 = $old_gp_image_2;
        }
        if ($gp_image_3 != '') {

            $image = $gp_image_3;
            //img  file  code  START
            //unique  file name
            $filename = time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            //Image::make($image_resize)->resize(400, null, function($constraint) {
            //  $constraint->aspectRatio();
            //});
            $image_resize->save('uploads/products/' . $filename);
            //img  file  code  end
            $gp_img_name_3 = $filename;
        } else {
            $gp_img_name_3 = $old_gp_image_3;
        }
        if ($gp_image_4 != '') {
//            $g_img_name_4 = time().rand(1, 100000).'.'.$gp_image_4->getClientOriginalExtension();
//            $gp_image_4->move('uploads/gallery_images',$g_img_name_4);
//            $gp_img_name_4 = $g_img_name_4;

            $image = $gp_image_4;
            //img  file  code  START
            //unique  file name
            $filename = time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            //Image::make($image_resize)->resize(400, null, function($constraint) {
            //  $constraint->aspectRatio();
            // });
            $image_resize->save('uploads/products/' . $filename);
            //img  file  code  end
            $gp_img_name_4 = $filename;
        } else {
            $gp_img_name_4 = $old_gp_image_4;
        }

        if ($request->real_stock == 0) {
            DB::table('products')->where('id', $request->id)
                ->update(['name' => $name, 'name_bn' => $name_bn, 'price' => $price, 'buy_price' => $buy_price, 'discount' => $discount, 'unit_quantity' => $quantity, 'stock_quantity' => $stock_quantity, 'unit' => $unit, 'description' => $description, 'tags' => $tags,
                    'category_id' => $category_id, 'sub_category_id' => $sub_category_id, 'child_sub_cats_id' => $child_sub_cats_id, 'brand_id' => $brand_id,
                    'featured_image' => $f_img_name, 'gp_image_1' => $gp_img_name_1, 'gp_image_2' => $gp_img_name_2, 'is_featured' => $is_featured, 'gp_image_3' => $gp_img_name_3, 'gp_image_4' => $gp_img_name_4, 'status' => $status,
                ]);
        } else {
            DB::table('products')->where('id', $request->id)
                ->update(['name' => $name, 'name_bn' => $name_bn, 'price' => $price, 'discount' => $discount, 'unit_quantity' => $quantity, 'unit' => $unit, 'description' => $description, 'tags' => $tags,
                    'category_id' => $category_id, 'sub_category_id' => $sub_category_id, 'child_sub_cats_id' => $child_sub_cats_id, 'brand_id' => $brand_id,
                    'featured_image' => $f_img_name, 'gp_image_1' => $gp_img_name_1, 'gp_image_2' => $gp_img_name_2, 'is_featured' => $is_featured, 'gp_image_3' => $gp_img_name_3, 'gp_image_4' => $gp_img_name_4, 'status' => $status,
                ]);
        }
        $request->session()->flash('status', 'Product Updated successfully.');
        return redirect()->back();
//        if (Auth::user()->role == 'admin') {
//            return redirect('ad/products');
//        } elseif (Auth::user()->role == 'manager') {
//            return redirect('pm/products');
//        }
    }


    public function update_medicine(Request $request)
    {
        if ($request->sub_category_id) {
            $sub_category_id = implode(",", $request->sub_category_id);
        } else {
            $sub_category_id = '';
        }

        $name = $request->name;
        $name_bn = $request->name_bn;
        $price = $request->price;
        $discount = $request->discount;
        $quantity = $request->unit_quantity;
        $stock_quantity = $request->stock_quantity;
        $is_featured = $request->is_featured;
        $buy_price = $request->buy_price;
        $unit = $request->unit;
        $status = $request->status;
        $description = $request->description;
        $brand_id = $request->brand_id;
        $tags = $request->tags;

        $f_image = $request->file('featured_img');


        $old_f_image = $request->old_featured_img;


        if ($f_image != '') {

            $image = $f_image;
            //unique  file name
            $filename = time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            // Image::make($image_resize)->resize(400, null, function($constraint) {
            //   $constraint->aspectRatio();
            //});
            $image_resize->save('uploads/products/' . $filename);

            //img  file  code  end
            $f_img_name = $filename;
        } else {
            $f_img_name = $old_f_image;
        }


        DB::table('products')->where('id', $request->id)
            ->update(['name' => $name, 'name_bn' => $name_bn, 'price' => $price, 'sub_category_id' => $sub_category_id, 'buy_price' => $buy_price, 'discount' => $discount, 'unit_quantity' => $quantity, 'stock_quantity' => $stock_quantity, 'unit' => $unit, 'description' => $description, 'tags' => $tags,
                'brand_id' => $brand_id, 'is_featured' => $is_featured,
                'featured_image' => $f_img_name, 'status' => $status,
            ]);
        $request->session()->flash('status', 'Medicine Updated successfully!');

        return redirect()->back();
    }

    public function vendor_product_update(Request $request)
    {

        if ($request->sub_category_id) {
            $sub_category_id_list = implode(",", $request->sub_category_id);
        } else {
            $sub_category_id_list = '';
        }
        if ($request->child_sub_cats_id) {
            $child_sub_category_id_list = implode(",", $request->child_sub_cats_id);
        } else {
            $child_sub_category_id_list = '';
        }

        $name = $request->name;
        $name_bn = $request->name_bn;
        $price = $request->price;
        $discount = $request->discount;
        $quantity = $request->unit_quantity;
        $stock_quantity = $request->stock_quantity;
        $unit = $request->unit;

        $category_id = $request->category_id;
        $sub_category_id = $sub_category_id_list;
        $child_sub_cats_id = $child_sub_category_id_list;
        $description = $request->description;
        $brand_id = $request->brand_id;
        $tags = $request->tags;

        $f_image = $request->file('featured_img');
        $gp_image_1 = $request->file('gp_image_1');
        $gp_image_2 = $request->file('gp_image_2');
        $gp_image_3 = $request->file('gp_image_3');
        $gp_image_4 = $request->file('gp_image_4');

        $old_f_image = $request->old_featured_img;
        $old_gp_image_1 = $request->old_gp_image_1;
        $old_gp_image_2 = $request->old_gp_image_2;
        $old_gp_image_3 = $request->old_gp_image_3;
        $old_gp_image_4 = $request->old_gp_image_4;

        if ($f_image != '') {

            $image = $f_image;
            //unique  file name
            $filename = time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            // Image::make($image_resize)->resize(400, null, function($constraint) {
            //   $constraint->aspectRatio();
            //});
            $image_resize->save('uploads/products/' . $filename);

            //img  file  code  end
            $f_img_name = $filename;
        } else {
            $f_img_name = $old_f_image;
        }

        if ($gp_image_1 != '') {

            $image = $gp_image_1;
            //img  file  code  START
            //unique  file name
            $filename = time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            //Image::make($image_resize)->resize(400, null, function($constraint) {
            //  $constraint->aspectRatio();
            //});
            $image_resize->save('uploads/products/' . $filename);
            //img  file  code  end
            $gp_img_name_1 = $filename;

        } else {
            $gp_img_name_1 = $old_gp_image_1;
        }

        if ($gp_image_2 != '') {
//            $g_img_name_2 = time().rand(1, 100000).'.'.$gp_image_2->getClientOriginalExtension();
//            $gp_image_2->move('uploads/gallery_images',$g_img_name_2);
//            $gp_img_name_2 = $g_img_name_2;

            $image = $gp_image_2;
            //unique  file name
            //img  file  code  START
            //unique  file name
            $filename = time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            //Image::make($image_resize)->resize(400, null, function($constraint) {
            //  $constraint->aspectRatio();
            //});
            $image_resize->save('uploads/products/' . $filename);
            //img  file  code  end
            $gp_img_name_2 = $filename;

        } else {
            $gp_img_name_2 = $old_gp_image_2;
        }
        if ($gp_image_3 != '') {

            $image = $gp_image_3;
            //img  file  code  START
            //unique  file name
            $filename = time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            //Image::make($image_resize)->resize(400, null, function($constraint) {
            //  $constraint->aspectRatio();
            //});
            $image_resize->save('uploads/products/' . $filename);
            //img  file  code  end
            $gp_img_name_3 = $filename;
        } else {
            $gp_img_name_3 = $old_gp_image_3;
        }
        if ($gp_image_4 != '') {
//            $g_img_name_4 = time().rand(1, 100000).'.'.$gp_image_4->getClientOriginalExtension();
//            $gp_image_4->move('uploads/gallery_images',$g_img_name_4);
//            $gp_img_name_4 = $g_img_name_4;

            $image = $gp_image_4;
            //img  file  code  START
            //unique  file name
            $filename = time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            //Image::make($image_resize)->resize(400, null, function($constraint) {
            //  $constraint->aspectRatio();
            // });
            $image_resize->save('uploads/products/' . $filename);
            //img  file  code  end
            $gp_img_name_4 = $filename;
        } else {
            $gp_img_name_4 = $old_gp_image_4;
        }


        DB::table('products')->where('id', $request->id)
            ->update(['name' => $name, 'name_bn' => $name_bn, 'price' => $price, 'buy_price' => $buy_price, 'discount' => $discount, 'unit_quantity' => $quantity, 'stock_quantity' => $stock_quantity, 'unit' => $unit, 'description' => $description, 'tags' => $tags,
                'category_id' => $category_id, 'sub_category_id' => $sub_category_id, 'child_sub_cats_id' => $child_sub_cats_id, 'brand_id' => $brand_id,
                'featured_image' => $f_img_name, 'gp_image_1' => $gp_img_name_1, 'gp_image_2' => $gp_img_name_2, 'gp_image_3' => $gp_img_name_3, 'gp_image_4' => $gp_img_name_4,
            ]);
        $request->session()->flash('status', 'Product Updated successfully!');
        return redirect('ve/vendor_product_list');

    }

    public function category()
    {
        return view('category');
    }


    public function create_category(Request $request)
    {
        $userId = Auth::id();
        $category = new Category();
        $category->cat_name = $request->cat_name;
        $category->cat_name_bn = $request->cat_name_bn;
        $category->cat_order = $request->order;
        $cat_img = $request->file('cat_img');
        $cat_banner = $request->file('cat_banner_img');
        $cat_icon = $request->file('cat_icon');


        if ($cat_banner != '') {
            $image = $cat_banner;
            //img  file  code  START
            //unique  file name
            $banner_filename = time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            //Image::make($image_resize)->resize(400, null, function($constraint) {
            //  $constraint->aspectRatio();
            //});
            $image_resize->save('uploads/cat_images/' . $banner_filename);
            //img  file  code  end

        } else {
            $banner_filename = '';
        }

        $cat_icon = $request->file('cat_icon');
        if ($cat_icon != '') {
            $image = $cat_icon;
            //img  file  code  START
            //unique  file name
            $icon_filename = time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            //Image::make($image_resize)->resize(400, null, function($constraint) {
            //  $constraint->aspectRatio();
            //});
            $image_resize->save('uploads/cat_images/' . $icon_filename);
            //img  file  code  end

        } else {
            $icon_filename = '';
        }
        if ($cat_img != '') {
            $image = $cat_img;
            //img  file  code  START
            //unique  file name
            $filename = time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            //Image::make($image_resize)->resize(400, null, function($constraint) {
            //  $constraint->aspectRatio();
            //});
            $image_resize->save('uploads/cat_images/' . $filename);
            //img  file  code  end

        } else {
            $filename = '';
        }

        $slug = Str::slug($request->cat_name, '-');
        $category->slug = $slug;
        $category->user_id = $userId;
        $category->cat_img = $filename;
        $category->cat_icon = $icon_filename;
        $category->cat_banner_img = $banner_filename;

        $category->save();
        $request->session()->flash('status', ' New Category  added successfully!');

        if (Auth::user()->role == 'admin') {
            return redirect('ad/category');
        } elseif (Auth::user()->role == 'manager') {
            return redirect('pm/category');
        }
    }


    public function daily_money_summary(Request $request)
    {

        $userId = Auth::id();
        $real_stock = $request->real_stock_amount + $request->deposit_amount;
        $plau_all = $request->due_amount + $request->waiting_stock_money + $request->incomplete_order_amount + $request->product_stock_amount + $request->hand_cash;
        $summary = $plau_all - $real_stock;

        DB::table('daily_summary')->insert(
            [
                'due_amount' => $request->due_amount,
                'waiting_stock_money' => $request->waiting_stock_money,
                'incomplete_order_amount' => $request->incomplete_order_amount,
                'product_stock_amount' => $request->product_stock_amount,
                'hand_cash' => $request->hand_cash,
                'real_stock_amount' => $request->real_stock_amount,
                'deposit_amount' => $request->deposit_amount,
                'user_id' => $userId,
                'summary' => $summary,
                'created_at' => Carbon::now()
            ]
        );
        $request->session()->flash('status', 'Day summary Added Success');

        return redirect()->back();
    }

    public function sub_category()
    {
        $category = Category::all();
        return view('sub_category', ['category' => $category]);
    }

    public function category_lists()
    {
        $categories = Category::all();
        return view('category-list', ['categories' => $categories]);
    }

    public function sub_category_lists()
    {
        $sub_categories = sub_category::all();
        return view('sub-category-list', ['sub_categories' => $sub_categories]);
    }


    public function create_sub_categories(Request $request)
    {


        $cat_banner = $request->file('banner');

        if ($cat_banner != '') {
            $image = $cat_banner;
            //img  file  code  START
            //unique  file name
            $banner_filename = time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            //Image::make($image_resize)->resize(400, null, function($constraint) {
            //  $constraint->aspectRatio();
            //});
            $image_resize->save('uploads/cat_images/' . $banner_filename);
            //img  file  code  end

        } else {
            $banner_filename = '';
        }

        $sub_cat = $request->file('cat_img');

        if ($sub_cat != '') {
            $image = $sub_cat;
            //img  file  code  START
            //unique  file name
            $banner_filename1 = time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            //Image::make($image_resize)->resize(400, null, function($constraint) {
            //  $constraint->aspectRatio();
            //});
            $image_resize->save('uploads/cat_images/' . $banner_filename1);
            //img  file  code  end

        } else {
            $banner_filename1 = '';
        }

        $userId = Auth::id();
        $sub_cat = new sub_category();

        $sub_cat->sub_cat_name = $request->sub_category_name;
        $sub_cat->sub_cat_name_bn = $request->sub_cat_name_bn;
        $slug = Str::slug($request->sub_category_name, '-');
        $sub_cat->slug = $slug;
        $sub_cat->banner = $banner_filename;
        $sub_cat->user_id = $userId;
        $sub_cat->category_id = $request->category_id;
        $sub_cat->cat_image = $banner_filename1;
        $sub_cat->save();
        $request->session()->flash('status', ' New Sub Category  added successfully!');

        if (Auth::user()->role == 'admin') {
            return redirect('ad/sub-category');
        } elseif (Auth::user()->role == 'manager') {
            return redirect('pm/sub-category');
        }

    }

    public function product_lists()
    {

            $products = DB::table('products as p')
//            ->join('categories as C', 'p.category_id', '=', 'C.id')
//            ->join('sub_categories as SC', 'p.sub_category_id', '=', 'SC.id')
            ->where('status', '=', 1)
            //->select('p.id', 'p.name', 'p.slug', 'p.price', 'p.discount', 'p.unit_quantity', 'p.stock_quantity', 'p.featured_image', 'p.gp_image_1', 'p.gp_image_2', 'p.gp_image_3', 'p.gp_image_4', 'p.unit', 'C.cat_name', 'SC.sub_cat_name')
            ->select('p.id', 'p.name', 'p.slug', 'p.price', 'p.discount', 'p.unit_quantity', 'p.stock_quantity', 'p.featured_image', 'p.gp_image_1', 'p.gp_image_2', 'p.gp_image_3', 'p.gp_image_4', 'p.unit')
            ->get();
 
        return view('products.active', ['products' => $products]);
    }

    public function big_buy_price_products()
    {
        $products = product::all();
        return view('products.big-buy-price-products', ['products' => $products]);
    }

    public function instock_product_lists_light()
    {
        $products = 1;
        return view('products.instock-product-light', ['products' => $products]);
    }



    public function regular_products()
    {

        $products = DB::table('products as p')
            ->join('categories as C', 'p.category_id', '=', 'C.id')
            ->join('sub_categories as SC', 'p.sub_category_id', '=', 'SC.id')
            //->join('child_sub_cats as CC','p.child_sub_cats_id','=','CC.id')
            ->select('p.id', 'p.name', 'p.name_bn', 'p.slug', 'p.price', 'p.discount', 'p.unit_quantity', 'p.stock_quantity', 'p.featured_image', 'p.gp_image_1', 'p.gp_image_2', 'p.gp_image_3', 'p.gp_image_4', 'p.unit', 'C.cat_name', 'SC.sub_cat_name')
            ->where('p.status', '=', '1')
            ->orderBy('p.name_bn', 'DESC')
            ->get();
        $lists = DB::table('regular_products')
            ->join('products as p', 'p.id', '=', 'regular_products.product_id')
            ->select('p.id')
            ->get();

        return view('products.regular-products', ['products' => $products, 'lists' => $lists]);
    }

    public function regular_checking_products()
    {

        $products = DB::table('regular_products')
            ->join('products', 'products.id', '=', 'regular_products.product_id')
            //->where('p.real_stock','=', '0')
            ->select('products.*')
            ->get();

        return view('products.regular_checking_products', ['products' => $products]);
    }


 public function delete_product($id)
    {
      DB::table('products')->where('id', '=', $id)->delete();
      return redirect()->back();
    }
    public function instock_product_buy_price_update($product_id, $price, $lowStockQuantity)
    {

//        $update = DB::table('products')->where('id', $product_id)->update(
//            [
//                'buy_price' => $price
//            ]);

        //assign  low stock  table  data
        DB::table('low_stock_products')->where('product_id', '=', $product_id)->delete();

        DB::table('low_stock_products')->insert([
            'quantity' => $lowStockQuantity,
            'product_id' => $product_id
        ]);


        return response()->json([
            'success' => 1
        ]);


    }

    public function low_stock_products()
    {
        $products = DB::table('products as p')
            ->join('low_stock_products as l', 'p.id', '=', 'l.product_id')
            ->where('p.status', '=', '1')
            ->select('p.id', 'p.name', 'p.name_bn', 'p.stock_quantity', 'l.quantity as low_quantity', 'p.unit', 'p.unit_quantity')
            ->get();
        $waiting_products = DB::table('waiting_stocks')
            ->get();

        $outOfStockProducts = DB::table('products as p')
            ->where('p.stock_quantity', '<=', 0)
            ->where('p.status', '=', '1')
            ->select('p.id', 'p.name', 'p.name_bn', 'p.stock_quantity', 'p.unit', 'p.unit_quantity')
            ->get();

        return view('products.print-low-stock-products', ['products' => $products, 'waiting_products' => $waiting_products, 'outOfStockProducts' => $outOfStockProducts]);
    }

    public function temp_instock_products_delete($id)
    {
        DB::table('products_temp_stock')->where('id', $id)->update(['is_deleted' => 1,'user_id'=> Auth::id()]);

        return redirect()->back();
    }


    public function single_temp_instock_products($id)
    {
        DB::table('temp_instock_products')->insert(
            ['product_id' => $id]
        );
        return redirect()->back();
    }

    public function temp_instock_products()
    {

        $products = DB::table('products')
            ->leftJoin('temp_instock_products', 'temp_instock_products.product_id', '=', 'products.id')
            ->where('products.buy_price', '>', '0')
            ->where('products.real_stock', '=', '1')
            ->select('products.*', 'temp_instock_products.product_id as temp_id')
            ->get();

        return view('products.temp_in-stock-products', ['products' => $products]);
    }

    public function order_lists_light(Request $request)
    {

        $orders = DB::table('orders')
            ->join('shippings', 'orders.id', '=', 'shippings.order_id');
         if ($request->data) {

             $orders =  $orders->where('shippings.name', 'like', '%' . $request->data . '%');
             $orders =  $orders->orWhere('shippings.phone', 'like', '%' . $request->data . '%');
        }
     $orders->select('orders.*', 'orders.id as  order_id', 'shippings.name as  name', 'shippings.phone as  phone');

        //$users = $users->orderBy('t_comparison_data.id', 'desc')->toSql();
        $orders = $orders->orderBy('orders.id', 'desc')->paginate(30);

//        $orders = DB::table('orders')
//            ->join('shippings', 'orders.id', '=', 'shippings.order_id');
////            if($request->data){
////                $orders->where('shippings.name', 'like', '%' . $request->data . '%');
////                $orders->orWhere('shippings.phone', 'like', '%' . $request->data . '%');
////            };
//        $orders->select('orders.*', 'orders.id as  order_id', 'shippings.name as  name', 'shippings.phone as  phone')
//            ->orderBy('orders.id', 'desc')->paginate(30);

        return view('orders.order-light', ['orders' => $orders]);
    }


    public function instock_products()
    {

        $products = DB::table('products')
            ->where('products.buy_price', '>', '0')
            ->where('products.real_stock', '=', '1')
            ->select('products.*')
            ->paginate(200);

        $lowstocks = DB::table('low_stock_products')
            ->get();

        return view('products.in-stock-products', ['products' => $products, 'lowstocks' => $lowstocks]);
    }

    public function product_location()
    {

        $products = DB::table('products')
            ->where('products.buy_price', '>=', '0')
            ->where('products.status', '=', 1)
            ->select('products.*')
            ->get();
        $product_stock_locations = DB::table('product_stock_locations')
            ->get();

        return view('products.product_location', ['products' => $products, 'product_stock_locations' => $product_stock_locations]);
    }

    public function update_product_location($product_id, $rak_no)
    {
        DB::table('product_stock_locations')->where('product_id', $product_id)->delete();

        DB::table('product_stock_locations')->insert(
            ['product_id' => $product_id, 'rak_no' => $rak_no]
        );
        return response()->json([
            'success' => 'Update Usccess'
        ]);


    }


    public function regular_product_price_update($id, $price, $discount)
    {

        $update = DB::table('products')->where('id', $id)->update(
            [
                'price' => $price,
                'discount' => $discount
            ]);
        $product = DB::table('products')
            ->where('id', '=', $id)
            ->first();

        return response()->json([
            'product' => $product
        ]);

    }


    public function regular_products_toogle($id)
    {
        $find = DB::table('regular_products')
            ->where('product_id', '=', $id)
            ->count();

        if ($find == 1) {
            regular_product::where('product_id', $id)->delete();
            return $id;
        } else {
            $regular_product = new regular_product();
            $regular_product->product_id = $id;
            $regular_product->save();
            return $id;
        }
        return '';
    }


    public function inactive()
    {

        $products = DB::table('products as p')
//            ->join('categories as C', 'p.category_id', '=', 'C.id')
//            ->join('sub_categories as SC', 'p.sub_category_id', '=', 'SC.id')
            ->where('status', '=', 0)
            //->select('p.id', 'p.name', 'p.slug', 'p.price', 'p.discount', 'p.unit_quantity', 'p.stock_quantity', 'p.featured_image', 'p.gp_image_1', 'p.gp_image_2', 'p.gp_image_3', 'p.gp_image_4', 'p.unit', 'C.cat_name', 'SC.sub_cat_name')
            ->select('p.id', 'p.name', 'p.slug', 'p.price', 'p.discount', 'p.unit_quantity', 'p.stock_quantity', 'p.featured_image', 'p.gp_image_1', 'p.gp_image_2', 'p.gp_image_3', 'p.gp_image_4', 'p.unit')
            ->get();

        return view('products.inactive', ['products' => $products]);
    }

    public function edit_product($id)
    {
        $product = product::find($id);
        $category = Category::all();
        $sub_category = sub_category::all();
        $child_sub_category = child_sub_cats::all();
        $brands = brand::orderBy("brand_name")->get();
        $units = unit::orderBy("unit_name")->get();
        return view('products.product-edit', ['units' => $units, 'product' => $product, 'category' => $category, 'sub_category' => $sub_category, 'child_sub_category' => $child_sub_category, 'brands' => $brands]);

    }

    public function edit_medicine($id)
    {
        $product = product::find($id);
        $category = Category::all();
        $sub_category = sub_category::all();
        $child_sub_category = child_sub_cats::all();
        $brands = brand::orderBy("brand_name")->get();
        $units = unit::orderBy("unit_name")->get();
        return view('medicines.edit-medicine', ['units' => $units, 'product' => $product, 'category' => $category, 'sub_category' => $sub_category, 'child_sub_category' => $child_sub_category, 'brands' => $brands]);

    }


    public function vendor_product_edit($id)
    {
        $userId = Auth::id();
        $checking = DB::table('products as p')
            ->where('p.user_id', '=', $userId)
            ->where('p.id', '=', $id)
            ->count();
        if ($checking == 1) {
            $product = product::find($id);
            $category = Category::all();
            $sub_category = sub_category::all();
            $child_sub_category = child_sub_cats::all();
            $brands = brand::orderBy("brand_name")->get();
            $units = unit::orderBy("unit_name")->get();
            return view('vendor.products.product-edit', ['units' => $units, 'product' => $product, 'category' => $category, 'sub_category' => $sub_category, 'child_sub_category' => $child_sub_category, 'brands' => $brands]);
        } else {
            return view('404');
        }

    }


    public function update_shipping($order_id, $address, $customer_name)
    {
        $update = DB::table('shippings')->where('order_id', $order_id)->update(
            [
                'name' => $customer_name,
                'address' => $address
            ]);
        return response()->json([
            'success' => $update
        ]);

    }

    public function update_note($order_id, $note)
    {
        $update = DB::table('orders')->where('id', $order_id)->update(
            [
                'notes' => $note,

            ]);
        return response()->json([
            'success' => $update
        ]);

    }

    public function update_expire_date($id, $date)
    {
        $date = date("Y-m-d", strtotime($date));
        $update = DB::table('product_stocks')->where('id', $id)->update(['expire_date' => $date]);
        if ($update == 1) {
            return response()->json([
                'success' => $id
            ]);
        }
    }


}
