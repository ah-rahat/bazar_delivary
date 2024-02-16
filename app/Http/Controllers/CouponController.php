<?php

namespace App\Http\Controllers;

use App\order;
use App\shipping;

use App\coupon;
use App\Http\Resources\coupon\couponResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{


    public function salary_list()
    {
        $employees = DB::table('employees')
            ->where('status', '=', 1)
            ->get();

        return view('employee.index', ['employees' => $employees]);
    }

    public function coupon_lists()
    {
        $coupons = DB::table('coupons')
            ->get();
        return view('coupon.index', ['coupons' => $coupons]);
    }

    public function new_coupon()
    {

        return view('coupon.add-coupon');
    }

    public function used_coupon()
    {
        $orders = DB::table('orders')
            ->join('marketers', 'marketers.coupon_code', '=', 'orders.coupon')
            ->select('orders.*', 'orders.id as  order_id')
            ->orderBy('orders.id', 'DESC')
            ->get();

        return view('orders.used-coupon', ['orders' => $orders]);
    }

    public function remove_used_coupon($id)
    {

        DB::table('orders')
            ->where('id', $id)->update(
                [
                    'coupon' => 'OFC-ORDER'
                ]);
        //$request->session()->flash('status', '  Coupon Updated Successfully.');
        return redirect()->back();
    }


    public function save_coupon(Request $request)
    {
        $userId = Auth::id();
        $coupon = new coupon();
        $coupon->coupon_code = $request->coupon_code;
        $coupon->coupon_discount = $request->coupon_discount;
        $coupon->status = 0;
        $coupon->active_from = date("Y-m-d", strtotime($request->active_from));
        $coupon->active_until = date("Y-m-d", strtotime($request->active_until));
        $coupon->created_by = $userId;
        $coupon->accepted_orders_amount = 1000000;
        $coupon->save();
        $request->session()->flash('status', 'New Coupon Added Successfully.');
        return redirect()->back();

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = DB::table('coupons')
            ->whereDate('coupons.active_from', '<=', now())
            ->whereDate('coupons.active_until', '>=', now())
            ->where('coupons.status', '=', 0)
            ->select('coupons.*')
            ->get();
        return new couponResource($coupons);
    }

    public function validate_coupon_test(Request $request)
    {
        $coupon = trim($request->coupon);
        $delivery_charge = trim($request->delivery_charge);
        $total_order_amount = $request->delivery_charge + $request->sum_cart_total;
        $check_coupons = DB::table('coupons')
            ->whereDate('coupons.active_from', '<=', now())
            ->whereDate('coupons.active_until', '>=', now())
            ->where('coupons.coupon_code', '=', $coupon)
            ->where('coupons.status', '=', 0)
            ->select('coupons.coupon_discount', 'coupons.active_from', 'coupons.active_until', 'coupons.start_time', 'coupons.end_time', 'coupons.not_for_valid_products', 'coupons.minimum_order_amount')
            ->first();

        if ($check_coupons) {
            if ($check_coupons->start_time && $check_coupons->end_time) {
                //$current_time = date('h');
                $startTime = $check_coupons->start_time;
                $endTime = $check_coupons->end_time;

                $currentHour = \Carbon\Carbon::now()->hour;
                $start = $startTime > $endTime ? !($startTime <= $currentHour) : $startTime <= $currentHour;
                $end = $currentHour < $endTime;

                if (!($start ^ $end)) {
                    if ($total_order_amount >= $check_coupons->minimum_order_amount) {
                        $cartsProductIdList = [];
                        foreach ($request->carts as $cart) {
                            array_push($cartsProductIdList, $cart['product_id']);
                        }
                        $not_for_valid_products_array = explode(",", $check_coupons->not_for_valid_products);
                        $resultArray = array_intersect($not_for_valid_products_array, $cartsProductIdList);
                        if (count($resultArray) > 0) {
                            $products_en = DB::table('products')
                                ->whereIn('id', $resultArray)
                                ->select('products.name as name_en')
                                ->get();
                            $products_bn = DB::table('products')
                                ->whereIn('id', $resultArray)
                                ->select('products.name_bn')
                                ->get();
                            return response(
                                [
                                    'coupon_discount' => 0,
                                    'not_valid_for_products' => $resultArray,
                                    'not_valid_for_product_name' => $products_bn,
                                    'en_not_valid_for_product_name' => $products_en
                                ], 200);
                        } else {
                            if ($check_coupons->coupon_discount === 'Free') {
                                $coupon_discount = $delivery_charge;
                            } else if (strpos($check_coupons->coupon_discount, "%") !== false) {
                                $coupon_discount = $check_coupons->coupon_discount;
                                $order_amount = $delivery_charge + $request->sum_cart_total;
                                $coupon_discount = ($order_amount * str_replace("%", "", $coupon_discount)) / 100;
                                $coupon_discount = (int)$coupon_discount;
                            } else {
                                $coupon_discount = $check_coupons->coupon_discount;
                            }
                            return response(
                                [
                                    'coupon_discount' => $coupon_discount,
                                ], 200);
                        }
                    } else {
                        return response(
                            [
                                'coupon_discount' => 0,
                                'message_en' => 'Order Minimum Amount ' . $check_coupons->minimum_order_amount . 'Tk to get Discount ',
                                'message_bn' => 'ডিসকাউন্ট পেতে সর্বনিম্ন  অর্ডার অ্যামাউন্ট ' . $check_coupons->minimum_order_amount . 'Tk',
                            ], 200);
                    }

                } else {
                    return response(
                        [
                            'coupon_discount' => 0,
                            'message_bn' => 'This Coupon is valid only between ' . date('h:i a', strtotime($check_coupons->start_time)) . ' To ' . date('h:i a', strtotime($check_coupons->end_time)),
                            'message_en' => 'কুপন  কোডটি  ভ্যালিড  শুধুমাত্র  ' . date('h:i a', strtotime($check_coupons->start_time)) . ' থেকে  ' . date('h:i a', strtotime($check_coupons->end_time)),
                        ], 200);
                }


            } else {
                //product compare
                $cartsProductIdList = [];
                foreach ($request->carts as $cart) {
                    array_push($cartsProductIdList, $cart['product_id']);
                }
                $not_for_valid_products_array = explode(",", $check_coupons->not_for_valid_products);
                $resultArray = array_intersect($not_for_valid_products_array, $cartsProductIdList);
                //product compare end
                if (count($resultArray) > 0) {
                    $products_en = DB::table('products')
                        ->whereIn('id', $resultArray)
                        ->select('products.name as name_en')
                        ->get();
                    $products_bn = DB::table('products')
                        ->whereIn('id', $resultArray)
                        ->select('products.name_bn')
                        ->get();

                    return response(
                        [
                            'coupon_discount' => 0,
                            'not_valid_for_products' => $resultArray,
                            'not_valid_for_product_name' => $products_bn,
                            'en_not_valid_for_product_name' => $products_en
                        ], 200);
                } else {
                    if ($request->order_total <= $check_coupons->minimum_order_amount) {
                        if ($check_coupons->coupon_discount === 'Free') {
                            $coupon_discount = $delivery_charge;
                        } else if (strpos($check_coupons->coupon_discount, "%") !== false) {
                            $coupon_discount = $check_coupons->coupon_discount;
                            $order_amount = $delivery_charge + $request->sum_cart_total;
                            $coupon_discount = ($order_amount * str_replace("%", "", $coupon_discount)) / 100;
                            $coupon_discount = (int)$coupon_discount;
                        } else {
                            $coupon_discount = $check_coupons->coupon_discount;
                        }
                        return response(
                            [
                                'coupon_discount' => $coupon_discount,
                            ], 200);
                    } else {
                        return response(
                            [
                                'coupon_discount' => 0,
                                'message_en' => 'Order Minimum amount ' . $check_coupons->minimum_order_amount . 'Tk to get Discount ',
                                'message_bn' => 'ডিসকাউন্ট পেতে সর্বনিম্ন  অর্ডার অ্যামাউন্ট ' . $check_coupons->minimum_order_amount . 'Tk',
                            ], 200);
                    }
                }
            }
        } else {
            return response(
                [
                    'coupon_discount' => 0,
                ], 200);
        }
    }


    public function validate_coupon(Request $request)
    {
        $check_coupons = DB::table('coupons')
            ->whereDate('coupons.active_from', '<=', now())
            ->whereDate('coupons.active_until', '>=', now())
            ->where('coupons.coupon_code', '=', $request->coupon)
            ->where('coupons.status', '=', 0)
            ->select('coupons.coupon_discount')->limit(1)
            ->get();
        return new couponResource($check_coupons);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit_coupon($id)
    {
        $coupon = coupon::find($id);
        return view('coupon.edit-coupon', ['coupon' => $coupon]);

    }

    public function update_coupon(Request $request)
    {

        DB::table('coupons')
            ->where('id', $request->id)->update(
                [
                    'coupon_code' => $request->coupon_code,
                    'coupon_discount' => $request->coupon_discount,
                    'active_from' => date("Y-m-d", strtotime($request->active_from)),
                    'active_until' => date("Y-m-d", strtotime($request->active_until)),
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'not_for_valid_products' => $request->not_for_valid_products,
                    'status' => $request->status,
                ]);
        $request->session()->flash('status', '  Coupon Updated Successfully.');
        return redirect()->back();

    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, coupon $coupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(coupon $coupon)
    {
        //
    }
}
