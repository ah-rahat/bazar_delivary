<?php

namespace App\Http\Controllers;

use  Symfony\Component\HttpFoundation\Response;
use App\Category;
use  App\product;
use App\sub_category;
use App\child_sub_cats;
use App\brand;
use App\restaurant;
use App\delivery_man;
use App\offer_image;
use App\order_item;
use App\shop_product;
use App\shop_order_item;
use App\shop_order;
use App\shop_shipping;
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

class ShopController extends Controller
{

    public function sales_calculation($start_date, $end_date)
    {

        $new_startDate = $start_date . ' 00:00:00';
        $new_endDate = $end_date . ' 23:59:59';

        $sales_data = DB::table('shop_orders')
            ->selectRaw("sum(order_total) as order_total, sum(delivery_charge) as delivery_charge,sum(coupon_discount_amount) as coupon_discount_amount")
            ->where('delivered_date', '>=', $new_startDate)
            ->where('delivered_date', '<=', $new_endDate)
            ->where('active_status', '=', 3)
            ->first();



        $buy_amount = DB::table('shop_orders')
            ->where('delivered_date', '>=', $new_startDate)
            ->where('delivered_date', '<=', $new_endDate)
            ->where('active_status', '=', 3)
            ->join('shop_order_items', 'shop_orders.id', '=', 'shop_order_items.order_id')
            ->select(DB::raw('sum(shop_order_items.total_buy_price) as total_buy_price'))
            ->first();


        return response()->json([
            'sales_data' => $sales_data,
            'buy_amount' => $buy_amount
        ]);

    }


    public function expire_products_show(){
        return view('shop.expires-list');
    }


    public function shop_dayend_sold_products($date){

        $date = date('Y-m-d', strtotime($date));

        $orders = DB::table('shop_orders')
            ->where('shop_orders.delivered_date', '>=', $date . ' 00:00:00')
            ->where('shop_orders.delivered_date', '<=', $date . ' 23:59:59')
            ->where('shop_orders.active_status', '=',  3)
            ->join('shop_order_items', 'shop_order_items.order_id', '=', 'shop_orders.id')
            ->join('shop_products', 'shop_products.id', '=', 'shop_order_items.product_id')
            ->select('shop_orders.id as  order_id','shop_order_items.product_id as product_id','shop_order_items.total_buy_price','shop_order_items.total_price','shop_products.name','shop_products.name_bn','shop_products.unit','shop_products.unit_quantity')
            ->orderBy('shop_orders.id', 'DESC')
            ->get();
        $orders_discount = DB::table('shop_orders')
            ->where('shop_orders.delivered_date', '>=', $date . ' 00:00:00')
            ->where('shop_orders.delivered_date', '<=', $date . ' 23:59:59')
            ->where('shop_orders.active_status', '=',  3)
            ->get();

        return view('shop.orders.today-sold-products', ['orders' => $orders,'orders_discount'=>$orders_discount]);
    }

    public function save_extra_money(Request $request){

        $values = array(
            'amount' => $request->amount,
            'today_extra_money' => 1,
            'user_id' => Auth::id() ,
            'date' => date('Y-m-d', strtotime($request->date)),
        );
        $res = DB::table('shop_investments')->insert($values);
        $request->session()->flash('status', 'Added successfully.');
        return redirect()->back();
    }

    public function save_shop_stock_money(Request $request){

        $values = array(
            'amount' => $request->amount,
            'type' => $request->type,
            'shop_id' => $request->shop_id,
            'user_id' => Auth::id() ,
            'date' => date('Y-m-d', strtotime($request->date)),
        );
        $res = DB::table('shop_investments')->insert($values);
        $request->session()->flash('status', 'Added successfully.');
        return redirect()->back();
    }
    public function save_shop_expense(Request $request){

        $values = array(
            'amount' => $request->amount,
            'purpose' => $request->purpose,
            'user_id' => Auth::id() ,
            'date' => date('Y-m-d', strtotime($request->date)),
        );
        $res = DB::table('shop_expenses')->insert($values);
        $request->session()->flash('status', 'Added successfully.');
        return redirect()->back();
    }

    public function shop_expense(){
        $shop_expenses = DB::table('shop_expenses')
            ->join('users', 'users.id', '=', 'shop_expenses.user_id')
            ->select('shop_expenses.*','users.name')
            ->get();
        return view('shop.invest.expense', ['shop_expenses' => $shop_expenses]);
    }
    public function extra_money(){
        $shop_investments = DB::table('shop_investments')
            ->where('shop_investments.today_extra_money', '=', 1)
            ->join('users', 'users.id', '=', 'shop_investments.user_id')
            ->select('shop_investments.*','users.name')
            ->get();
        return view('shop.invest.extra-money', ['shop_investments' => $shop_investments]);
    }

    public function investment(){
        $shop_investments = DB::table('shop_investments')
            ->get();

        return view('shop.invest.index', ['shop_investments' => $shop_investments]);
    }

    public function inactive_products(){
        $inactive_products = DB::table('shop_products')
            ->where('shop_products.status', '=', 0)
            ->get();
        return view('shop.inactive-products', ['products' => $inactive_products]);

    }

    public function index()
    {

        $check_new_order = DB::table('shop_orders')
            ->where('shop_orders.active_status', '=', 0)
            ->count();


        $today_date = date('Y-m-d');

        //$sales=DB::table('orders')
        // ->where('orders.active_status', '=',3)
        // ->where('orders.delivered_date', '>=',  $today_date.' 00:00:00')
        // ->where('orders.delivered_date', '<=', $today_date.' 23:59:59')
        // ->select(DB::raw('sum(order_total) as order_total'),DB::raw('sum(delivery_charge) as delivery_charge'),DB::raw('sum(coupon_discount_amount) as coupon_discount_amount'))
        // ->first();

//for show today   order count
        $today_orders = DB::table('shop_orders')->select(DB::raw('COUNT(*) as `count`'))
            ->where('shop_orders.delivered_date', '>=', $today_date . ' 00:00:00')
            ->where('shop_orders.delivered_date', '<=', $today_date . ' 23:59:59')
            ->where('shop_orders.active_status', '=', 3)
            ->get();

        $products = DB::table('shop_products')
            ->orderBy('shop_products.stock_quantity', 'ASC')
            ->where('shop_products.status', '=', 1)
            ->limit(10)
            ->get();
        $allproducts = DB::table('shop_products')
            ->get();

        $orders = DB::table('shop_orders')
            ->join('users', 'shop_orders.customer_id', '=', 'users.id')
            ->select('shop_orders.*', 'shop_orders.id as  order_id', 'users.name as  name', 'users.phone as  phone')
            ->orderBy('shop_orders.id', 'DESC')
            ->get();


        $sales = DB::table('shop_orders')
            ->where('shop_orders.active_status', '=', 3)
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

        $sales_summary = DB::table('shop_orders')
            ->where('shop_orders.active_status', '=', 3)
            ->select(DB::raw('sum(order_total) as order_total'), DB::raw('sum(delivery_charge) as delivery_charge'),
                DB::raw('sum(coupon_discount_amount) as coupon_discount_amount'))
            ->first();


        $delivered_sales_id = DB::table('shop_orders')
            ->where('shop_orders.active_status', '=', 3)
            ->select('shop_orders.id as order_id')
            ->get();


        //$total_buy_amount = DB::table('order_items')
        //->whereIn('order_id', [21,23,24])

        //->get();
        //return $total_buy_amount;


        $total_buy_amount = DB::table('shop_orders')
            ->join('shop_order_items', 'shop_orders.id', '=', 'shop_order_items.order_id')
            ->where('shop_orders.active_status', '=', 3)
            ->select(DB::raw('sum(shop_order_items.total_buy_price) as total_buy_price'))
            ->first();

        $total_avaiable_stock_amount = DB::table('shop_products')
            ->where('shop_products.buy_price', '>', 0)
            ->where('shop_products.stock_quantity', '>', 0)
            ->select(DB::raw('sum(shop_products.buy_price*shop_products.stock_quantity) as total_avaiable_stock_amount'))
            ->get()
            ->first();


        $sales_start_date = DB::table('shop_orders')
            ->where('shop_orders.active_status', '=', 3)
            ->select('shop_orders.created_at as sales_start_date')
            ->first();

        //count if not buy price added
        $last_date = date("Y-m-t");
        $first_date = date('Y-m-01');

//$today_date=date('Y-m-d');
        $check_if_not_price_add = DB::table('shop_orders')
            ->where('delivered_date', '>=', $first_date . ' 00:00:00')
            ->where('delivered_date', '<=', $last_date . ' 23:59:59')
            ->where('active_status', '=', 3)
            ->join('shop_order_items', 'shop_orders.id', '=', 'shop_order_items.order_id')
            ->where('shop_order_items.total_buy_price', '<=', 0)
            ->select('shop_orders.id as pending_id')
            ->get();
//->count();
//expected stock  money calculate


        $today_date = date('Y-m-d');

        //Due counting

        $incomplete_orders = DB::table('shop_orders')
            ->whereIn('active_status', [1, 2])
            ->select('id')->get()->toArray();
        //get order item
        $total_buy_price = 0;
        foreach ($incomplete_orders as $order) {


            $order_items = DB::table('shop_order_items')
                ->where('shop_order_items.order_id', '=', $order->id)
                ->select('shop_order_items.total_buy_price')->get()->toArray();


            foreach ($order_items as $item) {
                if ($item->total_buy_price) {
                    $buyprice = $item->total_buy_price;
                    $total_buy_price += $buyprice;
                }
            }

        }


        $today_added_products_in_stock = DB::table('shop_product_stocks')
            ->whereDate('created_at', DB::raw('CURDATE()'))
            ->get();
//        $deposit_requests = DB::table('deposit_requests')
//            ->where('status','=', 0)
//            ->count();


//        $deposits=DB::table('deposits')
//            ->select(DB::raw('sum(amount) as total_amount'))
//            ->first();
//        $purchase_deposit_amount=DB::table('due_purchase_history')
//            ->select(DB::raw('sum(amount) as amount'))
//            ->first();
        $today_sales_summary = DB::table('shop_orders')
            //->whereDate('delivered_date', '=', date('Y-m-d'))
            ->where('delivered_date', '>=', $today_date . ' 00:00:00')
            ->where('delivered_date', '<=', $today_date . ' 23:59:59')
            ->where('shop_orders.active_status', '=', 3)
            ->select(DB::raw('sum(order_total) as order_total'), DB::raw('sum(delivery_charge) as delivery_charge'),
                DB::raw('sum(coupon_discount_amount) as coupon_discount_amount'))
            ->first();
        $today_buy_amount = DB::table('shop_orders')
            ->join('shop_order_items', 'shop_orders.id', '=', 'shop_order_items.order_id')
            ->where('delivered_date', '>=', $today_date . ' 00:00:00')
            ->where('delivered_date', '<=', $today_date . ' 23:59:59')
            ->where('shop_orders.active_status', '=', 3)
            ->select(DB::raw('sum(shop_order_items.total_buy_price) as today_buy_amount'))
            ->first();

        $shop_taken_money = DB::table('shop_investments')
            ->where('type', '=',"money-minus")
            ->select(DB::raw('sum(amount) as taken_money'))
            ->first();
        $shop_given_money = DB::table('shop_investments')
            ->where('type', '=',"money-plus")
            ->select(DB::raw('sum(amount) as given_money'))
            ->first();
        $shop_total_avaiable_stock_amount = DB::table('shop_products')
            ->where('shop_products.buy_price', '>', 0)
            ->where('shop_products.stock_quantity', '>', 0)
            ->select(DB::raw('sum(shop_products.buy_price*shop_products.stock_quantity) as total_avaiable_stock_amount'))
            ->get()
            ->first();


        $shop_incomplete_orders = DB::table('shop_orders')
            ->whereIn('active_status', [1, 2])
            ->select('id')->get()->toArray();
        //get order item
        $shop_total_buy_price=0;
        foreach($shop_incomplete_orders as $order){
            $order_items = DB::table('shop_order_items')
                ->where('shop_order_items.order_id','=', $order->id)
                ->select('shop_order_items.total_buy_price')->get()->toArray();

            foreach ($order_items as $item){
                if( $item->total_buy_price ){
                    $buyprice = $item->total_buy_price;
                    $shop_total_buy_price+= $buyprice;
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
        $shop_expenses = DB::table('shop_expenses')
            ->select(DB::raw('sum(shop_expenses.amount) as shop_expenses'))
            ->first();


        return view('shop.home', [
            'shop_total_avaiable_stock_amount' => $shop_total_avaiable_stock_amount->total_avaiable_stock_amount,
            'shop_total_profit' => $shop_sales_summary->order_total + $shop_sales_summary->delivery_charge - $shop_sales_summary->coupon_discount_amount - $shop_total_buy_amount->total_buy_price,
            'shop_incomplete_order_total_buy_price' => $shop_total_buy_price,
            'shop_given_stock_money' => $shop_given_money->given_money,
            'shop_taken_stock_money' => $shop_taken_money->taken_money,
            'shop_expenses' => $shop_expenses->shop_expenses,
            //'today_expense' => $today_expense,
            //'stock_summary' => $summary,
            //'remaining_deposit_money' => $deposits->total_amount - $purchase_deposit_amount->amount,
            //'deposit_requests' => $deposit_requests,
            //'total_due_amount' => $total_due_amount,
            //'waiting_stock_money' => $waiting_stock_money,
            //'total_due_paid' => $total_due_paid,
            //'minus_from_stock_amount' => $given_money->given_money,
            //'plus_for_stock_amount' => $taken_money->taken_money,
            'allproducts' => $allproducts,
            'today_buy_amount' => $today_buy_amount,
            'today_sales_summary' => $today_sales_summary,
            'today_added_products_in_stock' => $today_added_products_in_stock,
            'incomplete_order_buy_price' => $total_buy_price,
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
            //'vendor_request_count' => $vendor_request_count,
            //'daily_summary' => $daily_summary

        ]);
    }

    public function product_lists()
    {
        $products = DB::table('shop_products as p')
            ->where('p.status', '=', 1)
            ->join('categories as C', 'p.category_id', '=', 'C.id')
            ->join('sub_categories as SC', 'p.sub_category_id', '=', 'SC.id')

            ->select('p.id as product_id', 'p.name', 'p.name_bn', 'p.slug', 'p.price', 'p.discount', 'p.unit', 'p.unit_quantity', 'p.stock_quantity', 'p.featured_image', 'p.gp_image_1', 'p.gp_image_2', 'p.gp_image_3', 'p.gp_image_4', 'C.cat_name', 'SC.sub_cat_name')
            ->get();

        return view('shop.products', ['products' => $products]);
    }

    public function edit_product($id)
    {
        $product = DB::table('shop_products')->where('id', $id)->first();
        $category = Category::all();
        $sub_category = sub_category::all();
        $child_sub_category = child_sub_cats::all();
        $brands = brand::orderBy("brand_name")->get();
        $units = unit::orderBy("unit_name")->get();

        return view('shop.product-edit', ['role' => Auth::user()->role, 'units' => $units, 'product' => $product, 'category' => $category, 'sub_category' => $sub_category, 'child_sub_category' => $child_sub_category, 'brands' => $brands]);

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
        $sub_category_id = $sub_category_id_list;
        $child_sub_cats_id = $child_sub_category_id_list;
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

        if ($request->real_stock == 0) {
            $res = DB::table('shop_products')->where('id', $request->id)
                ->update(['name' => $name, 'name_bn' => $name_bn, 'price' => $price, 'buy_price' => $buy_price, 'discount' => $discount, 'unit_quantity' => $quantity, 'stock_quantity' => $stock_quantity, 'unit' => $unit, 'description' => $description, 'tags' => $tags,
                    'category_id' => $category_id, 'sub_category_id' => $sub_category_id, 'child_sub_cats_id' => $child_sub_cats_id, 'brand_id' => $brand_id,
                    'featured_image' => $f_img_name, 'status' => $status
                ]);

        } else {
            $res = DB::table('shop_products')->where('id', $request->id)
                ->update(['name' => $name, 'name_bn' => $name_bn, 'price' => $price, 'discount' => $discount, 'unit_quantity' => $quantity, 'unit' => $unit, 'description' => $description, 'tags' => $tags,
                    'category_id' => $category_id, 'sub_category_id' => $sub_category_id, 'child_sub_cats_id' => $child_sub_cats_id, 'brand_id' => $brand_id,
                    'featured_image' => $f_img_name, 'status' => $status, 'real_stock' => 1
                ]);

        }
        $request->session()->flash('status', 'Product Updated successfully.');
        return redirect()->back();

    }
    public function update_expire_date($id, $date)
    {
        $date=  date("Y-m-d", strtotime($date));
        $update = DB::table('shop_product_stocks')->where('id', $id)->update(['expire_date' => $date]);
        if($update == 1){
            return response()->json([
                'success' => $id
            ]);
        }
    }

    public function stock()
    {
        return view('shop.add-stock');
    }

    public function store_stock($date, $product_id, $stock_quantity, $price)
    {
        DB::beginTransaction();
        try {
            $product = DB::table('shop_products')
                ->where('id', '=', $product_id)
                ->first();
            $old_stock_quantity = $product->stock_quantity;
            $total_buy_price = $product->buy_price * $product->stock_quantity + $price;
            $new_stock_quantity = $stock_quantity + $old_stock_quantity;
            $new_buy_price = round($total_buy_price / $new_stock_quantity, 2);

            //update  price
            $update = DB::table('shop_products')->where('id', $product_id)->update(['stock_quantity' => $new_stock_quantity, 'buy_price' => ceil($new_buy_price * 100) / 100]);

            $stock = DB::table('shop_product_stocks')->insert([
                'product_id' => $product_id,
                'expire_date' => $date,
                'quantity' => $stock_quantity,
                'price' => $price,
                'old_stock' => $old_stock_quantity,
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


    public function findsales_quantity($product_id)
    {
        DB::beginTransaction();
        try {
            $stock = DB::table('shop_order_items')
                ->where('product_id', '=', $product_id)
                ->join('shop_orders', 'shop_orders.id', '=', 'shop_order_items.order_id')
                ->where('shop_orders.active_status', '=', 3)
                ->select(DB::raw('sum(quantity) as get_total'))
                ->first();
            $isinSale = DB::table('shop_order_items')
                ->where('product_id', '=', $product_id)
                ->join('shop_orders', 'shop_orders.id', '=', 'shop_order_items.order_id')
                ->whereIn('active_status', [0, 1, 2])
                ->select(DB::raw('sum(quantity) as get_total'))
                ->first();
            $stockLists = DB::table('shop_product_stocks')
                ->where('product_id', '=', $product_id)
                ->join('users', 'users.id', '=', 'shop_product_stocks.user_id')
                ->select('shop_product_stocks.id as product_stock_id', 'shop_product_stocks.quantity', 'shop_product_stocks.price', 'shop_product_stocks.expire_date', 'shop_product_stocks.created_at', 'users.name')
                ->orderBy('shop_product_stocks.id', 'desc')
                ->get();
            DB::commit();
            return response()->json([
                'quantity' => $stock,
                'isinSale' => $isinSale,
                'stockLists' => $stockLists
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), $e->getCode());
            // something went wrong
        }

    }

    public function need_to_add_stock_products()
    {

        $products = DB::table('shop_products')
            ->where('shop_products.real_stock', '=', '0')
            ->join('categories', 'categories.id', '=', 'shop_products.category_id')
            ->where('categories.id', '!=', '14')
            ->join('sub_categories', 'sub_categories.id', '=', 'shop_products.sub_category_id')
            ->where('sub_categories.id', '!=', '284')
            ->select('shop_products.*')
            ->get();


        return view('shop.need-to-add-stock-products', ['products' => $products]);
    }


    public function instock_products()
    {

        $products = DB::table('shop_products')
            ->where('shop_products.buy_price', '>', '0')
            ->where('shop_products.real_stock', '=', '1')
            ->select('shop_products.*')
            ->get();

        $lowstocks = DB::table('shop_low_stock_products')
            ->get();

        return view('shop.in-stock-products', ['products' => $products, 'lowstocks' => $lowstocks]);
    }

    public function add_product()
    {
        $category = Category::all();
        $sub_category = sub_category::all();
        $child_sub_category = child_sub_cats::all();
        $units = unit::all();
        $brands = brand::all();
        return view('shop.add-product', ['units' => $units, 'category' => $category, 'sub_category' => $sub_category, 'brands' => $brands, 'child_sub_category' => $child_sub_category]);
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

        $slug = Str::slug($request->name, '-');
        $data['data'] = DB::table('shop_products')->where('slug', $slug)->first();
        if (count($data) > 0) {
            $slug = $slug . '-' . rand(1, 300);
        } else {
            $slug = $slug;
        }
        //featured  image
        $f_image = $request->file('featured_img');

        $image = $f_image;
        //unique  file name
        $filename = time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();
        $image_resize = Image::make($image->getRealPath());
        //Image::make($image_resize)->resize(400, null, function($constraint) {
        //  $constraint->aspectRatio();
        //});
        $image_resize->save('uploads/products/' . $filename);


        $values = array('name' => $request->name, 'name_bn' => $request->name_bn,
            'tags' => $request->tags,
            'brand_id' => $request->brand_id,
            'description' => $request->description,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'featured_image' => $filename,
            'sub_category_id' => $sub_category_id_list,
            'child_sub_cats_id' => $child_sub_category_id_list,
            'price' => $request->price,
            'buy_price' => $request->buy_price,
            'unit_quantity' => $request->unit_quantity,
            'stock_quantity' => $request->stock_quantity,
            'unit' => $request->unit,
            'real_stock' => 0,
            'status' => $request->status,
            'user_id' => $userId,
        );
        $res = DB::table('shop_products')->insert($values);


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

    public function admin_custom_order()
    {

        $products = DB::table('shop_products')
            ->get();

        $shippings = DB::table('shop_shippings')
            ->get();
        return view('shop.orders.shop-custom-order', ['shippings' => $shippings, 'products' => $products]);

    }


    public function single_order($id)
    {
        $order_custumer_info = DB::table('shop_orders')
            ->join('shop_payments', 'shop_payments.order_id', '=', 'shop_orders.id')
            ->join('shop_shippings', 'shop_shippings.order_id', '=', 'shop_orders.id')
            ->where('shop_orders.id', '=', $id)
            ->select('shop_orders.*', 'shop_shippings.name as  name', 'shop_shippings.phone as  phone', 'shop_shippings.address as  address', 'shop_shippings.order_id as  order_id', 'shop_shippings.area as  area', 'shop_payments.payment_type as  payment_type', 'shop_payments.transaction_number as  transaction_number')
            ->first();
        // $today=date('y-m-d');
        // $deliverd_date=$order_custumer_info->delivered_date;
        // return $dateDifference=$today->diff($deliverd_date);
        ///dd($order_custumer_info);
        if ($order_custumer_info->delivered_date) {
            $today = date('Y-m-d');
            $deliverd_date = date('Y-m-d', strtotime($order_custumer_info->delivered_date));
            $start_date = \Carbon\Carbon::createFromFormat('Y-m-d', $deliverd_date);
            $end_date = \Carbon\Carbon::createFromFormat('Y-m-d', $today);
            $different_days = $start_date->diffInDays($end_date);
        } else {
            $different_days = 0;
        }

        $order_products = DB::table('shop_order_items')->where('order_id', $id)->get();
        $products = DB::table('shop_products')->get();;
//        $restaurants = restaurant::all();

        $get_order_total = DB::table('shop_order_items')
            ->where('shop_order_items.order_id', $id)
            ->select(DB::raw('sum(shop_order_items.total_price) as get_order_total'))
            ->first();

        $delivery_mans = DB::table('delivery_mans')->where('status', 1)->get();
        $customize_products = DB::table('shop_customize_products')->get();
        //fins buy  price is  empty
        $empty_buy_price_count = DB::table('shop_orders')
            ->where('shop_orders.id', '=', $id)
            ->join('shop_order_items', 'shop_orders.id', '=', 'shop_order_items.order_id')
            ->where('shop_order_items.total_buy_price', '<=', 0)
            ->count();
        //profit calculate
        $total_buy_amount = DB::table('shop_orders')
            ->where('shop_orders.id', '=', $id)
            ->join('shop_order_items', 'shop_orders.id', '=', 'shop_order_items.order_id')
            ->select(DB::raw('sum(shop_order_items.total_buy_price) as total_buy_price'))
            ->first();
        $total_sale_amount = DB::table('shop_orders')
            ->where('shop_orders.id', '=', $id)
            ->join('shop_order_items', 'shop_orders.id', '=', 'shop_order_items.order_id')
            ->select(DB::raw('sum(shop_order_items.total_price) as total_sale_price'))
            ->first();

        $profit = $total_sale_amount->total_sale_price - $total_buy_amount->total_buy_price + $order_custumer_info->delivery_charge - $order_custumer_info->coupon_discount_amount;


        return view('shop.orders.single-order', ['empty_buy_price_count' => $empty_buy_price_count, 'different_days' => $different_days, 'profit' => $profit, 'shop_customize_products' => $customize_products, 'delivery_mans' => $delivery_mans, 'get_order_total' => $get_order_total, 'customize_products' => $customize_products, 'order_products' => $order_products, 'products' => $products, 'order_custumer' => $order_custumer_info, 'order_id' => $id]);

    }

    public function single_order_print($id)
    {

        $order_custumer_info = DB::table('shop_orders')
            ->join('shop_payments', 'shop_payments.order_id', '=', 'shop_orders.id')
            ->join('shop_shippings', 'shop_shippings.order_id', '=', 'shop_orders.id')
            ->where('shop_orders.id', '=', $id)
            ->select('shop_orders.*', 'shop_shippings.name as  name', 'shop_shippings.phone as  phone', 'shop_shippings.address as  address', 'shop_shippings.order_id as  order_id', 'shop_shippings.area as  area', 'shop_payments.payment_type as  payment_type', 'shop_payments.transaction_number as  transaction_number')
            ->first();

        $order_products = DB::table('shop_order_items')->where('order_id', $id)->get();
        $products = DB::table('shop_products')->get();
        return view('shop.orders.print', ['order_products' => $order_products, 'products' => $products, 'order_custumer' => $order_custumer_info, 'order_id' => $id]);
    }

    public function today_orders()
    {

        $today_date = date('Y-m-d');
        $orders = DB::table('shop_orders')
            ->join('shop_shippings', 'shop_orders.id', '=', 'shop_shippings.order_id')
            ->where('shop_orders.created_at', '>=', $today_date . ' 00:00:00')
            ->where('shop_orders.created_at', '<=', $today_date . ' 23:59:59')
            ->whereIn('shop_orders.active_status', [0, 1, 2])
            ->select('shop_orders.*', 'shop_orders.id as  order_id', 'shop_shippings.name as  name', 'shop_shippings.phone as  phone')
            ->orderBy('shop_orders.id', 'DESC')
            ->get();

        $old_orders = DB::table('shop_orders')
            ->join('shop_shippings', 'shop_orders.id', '=', 'shop_shippings.order_id')
            ->where('shop_orders.created_at', '<', $today_date . ' 00:00:00')
            ->whereIn('shop_orders.active_status', [0, 1, 2])
            ->select('shop_orders.*', 'shop_orders.id as  order_id', 'shop_shippings.name as  name', 'shop_shippings.phone as  phone')
            ->orderBy('shop_orders.id', 'DESC')
            ->get();

        return view('shop.orders.today-orders', ['orders' => $orders, 'old_orders' => $old_orders, 'date' => '']);
    }

    public function order_index()
    {
        $orders = DB::table('shop_orders')
            ->join('shop_shippings', 'shop_orders.id', '=', 'shop_shippings.order_id')
            ->select('shop_orders.*', 'shop_orders.id as  order_id', 'shop_shippings.name as  name', 'shop_shippings.phone as  phone')
            ->orderBy('shop_orders.id', 'DESC')
            ->get();

        return view('shop.orders.index', ['orders' => $orders]);
    }

    public function today_delivered_orders()
    {
        $today = date('Y-m-d');
        $orders = DB::table('shop_orders')
            ->join('shop_shippings', 'shop_orders.id', '=', 'shop_shippings.order_id')
            ->where('shop_orders.delivered_date', '>=', $today . ' 00:00:00')
            ->where('shop_orders.delivered_date', '<=', $today . ' 23:59:59')
            ->where('shop_orders.active_status', '=', 3)
            ->select('shop_orders.*', 'shop_orders.id as  order_id', 'shop_shippings.name as  name', 'shop_shippings.phone as  phone')
            ->orderBy('shop_orders.id', 'DESC')
            ->get();


        return view('shop.orders.today-delivered-orders', ['orders' => $orders, 'date' => $today]);
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
                $get_order_total = DB::table('shop_order_items')
                    ->where('shop_order_items.order_id', $request->order_id)
                    ->select(DB::raw('sum(total_price) as get_order_total'))
                    ->first();

                $status = DB::table('shop_orders')
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

                //  $url = "http://66.45.237.70/api.php";
//            $number='88'.$request->phone;
//            $text="Your  order is  in transport.  you will receive your delivery  soon.";
//            $data= array(
//            'username'=>'monircis',
//            'password'=>'Monir6789Z',
//            'number'=>$number,
//            'message'=>$text
//            );
//
//            $ch = curl_init(); // Initialize cURL
//            curl_setopt($ch, CURLOPT_URL,$url);
//            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//            $smsresult = curl_exec($ch);
//            $p = explode("|",$smsresult);
//            $sendstatus = $p[0];
                DB::commit();
                $request->session()->flash('status', ' Order Status Updated successfully ');
                return redirect()->back();
            } elseif ($request->status == 'transit') {
                $status = DB::table('shop_orders')->where('id', $request->order_id)->update(['delivery_man_id' => $delivery_man_id, 'transit_status' => 1, 'transit_date' => $date_time, 'updated_at' => $date_time, 'active_status' => 2, 'user_id' => Auth::id()]);

                $order_summary = DB::table('shop_orders')
                    ->where('shop_orders.id', '=', $order_id)
                    ->select('shop_orders.order_total as  order_total', 'shop_orders.delivery_charge as  delivery_charge', 'shop_orders.coupon_discount_amount as  coupon_discount_amount')
                    ->first();

                $total_bill_amount = $order_summary->order_total + $order_summary->delivery_charge - $order_summary->coupon_discount_amount;

                if ($request->status == 'transit' && $request->sms == 'YES') {

                    //transit  user  info get
                    $delivery_person = DB::table('delivery_mans')
                        ->where('delivery_mans.id', '=', $delivery_man_id)
                        ->first();


//                    $url = "http://66.45.237.70/api.php";
//                    $number = '88' . $request->phone;
//                    $text = "Your  order is  in Transport. Total payable amount: $total_bill_amount Taka. Delivery Man: $delivery_person->name Contact Number: $delivery_person->phone";
//                    $data = array(
//                        'username' => 'monircis',
//                        'password' => 'Monir6789Z',
//                        'number' => $number,
//                        'message' => $text
//                    );
//
//                    $ch = curl_init(); // Initialize cURL
//                    curl_setopt($ch, CURLOPT_URL, $url);
//                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
//                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//                    $smsresult = curl_exec($ch);
//                    $p = explode("|", $smsresult);
//                    $sendstatus = $p[0];
                }
                DB::commit();
                $request->session()->flash('status', ' Order Status Updated successfully and SMS Sent to users');
                return redirect()->back();

            } elseif ($request->status == 'deivered') {

                $status = DB::table('shop_orders')->where('id', $request->order_id)->update(['delivery_man_id' => $delivery_man_id, 'delivered_status' => 1, 'delivered_date' => $date_time, 'updated_at' => $date_time, 'active_status' => 3, 'user_id' => Auth::id()]);
                DB::commit();
                $request->session()->flash('status', ' Order Status Updated successfully');
                return redirect()->back();


            } elseif ($request->status == 'cancel') {
                $status = DB::table('shop_orders')->where('id', $request->order_id)->update(['delivery_man_id' => $delivery_man_id, 'cancel_status' => 1, 'cancel_date' => $date_time, 'updated_at' => $date_time, 'active_status' => 4, 'user_id' => Auth::id()]);

                $order_products = DB::table('shop_order_items')->where('order_id', $request->order_id)->get();

                //increment product  when cancel
                foreach ($order_products as $singleProduct) {

                    //update  stock _quantity
                    $stock = DB::table('shop_products')
                        ->where('shop_products.id', '=', $singleProduct->product_id)
                        ->select('shop_products.stock_quantity as prev_stock')
                        ->first();
                    // "OLD STOCK = " .
                    $new_stock = $stock->prev_stock + $singleProduct->quantity;

                    DB::table('shop_products')->where('id', $singleProduct->product_id)->update(
                        [
                            'stock_quantity' => $new_stock,
                        ]
                    );

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

    public function customer_order_received_status_update(Request $request)
    {
        $result = DB::table('shop_orders')
            ->where('id', $request->order_id)
            ->update([
                'c_order_received' => now(),
            ]);
        $request->session()->flash('status', 'Customer Received Successfully');
        return redirect()->back();

    }



    public function update_note($order_id, $note)
    {
        $update = DB::table('shop_orders')->where('id', $order_id)->update(
            [
                'notes' => $note,

            ]);
        return response()->json([
            'success' => $update
        ]);

    }

    public function single_custom_order($id)
    {

        $order_custumer_info = DB::table('shop_orders')
            //->join('users', function ($join)use($id) {
            //  $join->on('users.id', '=', 'orders.customer_id')
            //      ->where('orders.id', '=', $id);
            // })
            ->join('shop_payments', 'shop_payments.order_id', '=', 'shop_orders.id')
            ->join('shop_shippings', 'shop_shippings.order_id', '=', 'shop_orders.id')
            ->where('shop_orders.id', '=', $id)
            ->select('shop_orders.*', 'shop_shippings.name as  name', 'shop_shippings.phone as  phone', 'shop_shippings.address as  address', 'shop_shippings.order_id as  order_id', 'shop_shippings.area as  area', 'shop_payments.payment_type as  payment_type', 'shop_payments.transaction_number as  transaction_number')
            ->first();

        $order_products = DB::table('shop_order_items')->where('order_id', $id)->get();
        $products = DB::table('shop_products')->get();

        return view('shop.orders.custom-order', ['order_products' => $order_products, 'products' => $products, 'order_custumer' => $order_custumer_info, 'order_id' => $id]);
    }


    public function custom_order_product(Request $request)
    {
        DB::beginTransaction();
        try {
        if ($request->product_id) {

            foreach ($request->product_id as $key => $v) {
                $find = DB::table('shop_order_items')
                    ->where('order_id', '=', $request->id)
                    ->where('product_id', '=', $request->product_id[$key])
                    ->count();
                if ($find == 0) {
                    $pricedata = DB::table('shop_products')
                        ->where('shop_products.id', '=', $request->product_id[$key])
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
                    shop_order_item::insert($data_arr);

                    //update stock

                    DB::table('shop_products')
                        ->where('shop_products.id', '=', $request->product_id[$key])
                        ->decrement('shop_products.stock_quantity', $request->quantity[$key]);


                    $get_order_total = DB::table('shop_order_items')
                        ->where('shop_order_items.order_id', '=', $request->id)
                        ->select(DB::raw('sum(total_price) as total_price'))
                        ->first();
                    $get_order_total = $get_order_total->total_price;

                    DB::table('shop_orders')
                        ->where('id', $request->id)
                        ->update(['order_total' => $get_order_total]);

                    if ($request->delivery_dicsount > 0) {
                        DB::table('shop_orders')->where('id', $request->id)->update(['coupon_discount_amount' => $request->delivery_dicsount, 'coupon' => 'SHOP']);
                    }
                }
            }

        } else {

            if ($request->delivery_dicsount > 0) {
                DB::table('shop_orders')->where('id', $request->id)->update(['coupon_discount_amount' => $request->delivery_dicsount, 'coupon' => 'SHOP']);
            }
        }


            DB::commit();
            $request->session()->flash('status', 'Product Added Successfully');
            return redirect('shop/order/' . $request->id);

        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'Something Wrong');
            return redirect('shop/order/' . $request->id);
        }
    }


    public function custom_order($order_id, $product_id, $quantity)
    {
        $item = DB::table('shop_order_items')
            ->where('product_id', '=', $product_id)
            ->where('order_id', '=', $order_id)
            ->delete();

        $get_order_total = DB::table('shop_order_items')
            ->where('shop_order_items.order_id', '=', $order_id)
            ->select(DB::raw('sum(total_price) as total_price'))
            ->first();
        $get_order_total = $get_order_total->total_price;

        DB::table('shop_orders')
            ->where('id', $order_id)
            ->update(['order_total' => $get_order_total]);

        //update  stock _quantity
        DB::table('shop_products')
            ->where('shop_products.id', '=', $product_id)
            ->increment('shop_products.stock_quantity', $quantity);
        return redirect()->back();
    }


    public function order_product_buy_price_update($order_id, $product_id, $buy_price)
    {
        return DB::table('shop_order_items')
            ->where(['order_id' => $order_id, 'product_id' => $product_id])
            ->update(['total_buy_price' => $buy_price]);

    }

    public function shop_order_activity()
    {

          $roleurl = 'shop/order/';

            $orders = DB::table('shop_orders')
                ->select('shop_orders.*')
                ->orderBy('shop_orders.updated_at', 'DESC')->take(13)
                ->get();
        $li = '<div>';
            foreach ($orders as $order) {

                if ($order->active_status == 0) {

                    $li .= '<div class="each-activity create"> 
      <a href="'.URL::to('/') . $roleurl . $order->id . '"><span><i>#' . $order->id . '</i> A New Order has  been created</span> <br /><i class="fa fa-clock-o"></i> ' . date('h:i A', strtotime($order->updated_at)) . '</a></div>';
                } elseif ($order->active_status == 1) {
                    $li .= '<div class="each-activity create"><a href="'.URL::to('/')  . $roleurl . $order->id . '"><span><i>#' . $order->id . '</i> A New Order has  been created</span> <br /><i class="fa fa-clock-o"></i> ' . date('h:i A', strtotime($order->updated_at)) . '</a></div>';
                } elseif ($order->active_status == 2) {
                    $li .= '<div class="each-activity transit"><a href="'.URL::to('/')  . $roleurl . $order->id . '"><span><i>#' . $order->id . '</i> Order is In Transit</span> <br /><i class="fa fa-clock-o"></i> ' . date('h:i A', strtotime($order->updated_at)) . '</a></div>';
                } elseif ($order->active_status == 3) {
                    $li .= '<div class="each-activity done"><a href="'.URL::to('/')  . $roleurl . $order->id . '"><span><i>#' . $order->id . '</i> Order has  been Delivered successfully</span> <br /><i class="fa fa-clock-o"></i> ' . date('h:i A', strtotime($order->updated_at)) . '</a></div>';
                } elseif ($order->active_status == 4) {
                    $li .= '<div class="each-activity cancel"><a href="'.URL::to('/')  . $roleurl . $order->id . '"><span><i>#' . $order->id . '</i> Order has  been Cancelled</span> <br /><i class="fa fa-clock-o"></i> ' . date('h:i A', strtotime($order->updated_at)) . '</a></div>';
                }

            }
            $li .= '</div>';

            return response()->json(['success' => $li]);


            //return response()->json(['success'=>$orders

            //return response()->json(array('msg'=> $orders), 200);

        }


}
