<?php

namespace App\Http\Controllers;

use App\Http\Requests\productRequest;
use App\Http\Resources\product\productCollection;
use App\Http\Resources\product\productResource;
use App\Http\Resources\product\searchProductResource;
use App\product;
use App\product_request;
use App\vendor_request;
use GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use  Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
class productController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api')->except('index','show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function temp_products_final_update(Request $request){
        DB::beginTransaction();
        try {
            $product = DB::table('products')
                ->where('id', '=', $request->product_id)
                ->first();
            $old_stock_quantity = $product->stock_quantity;
            $old_stock_buy_price = $product->buy_price;
            $total_buy_price = $product->buy_price * $product->stock_quantity +$request->buy_price;
            $new_stock_quantity = $request->quantity + $old_stock_quantity;
            $new_buy_price = round($total_buy_price / $new_stock_quantity, 2);

            //update  price
            $update = DB::table('products')->where('id', $request->product_id)->update(['stock_quantity' => $new_stock_quantity, 'buy_price' => ceil($new_buy_price * 100) / 100]);
            DB::table('products_temp_stock')->where('id', $request->products_temp_stock_row_id)->update(['is_deleted' => 1]);

            $stock = DB::table('product_stocks')->insert([
                'product_id' => $request->product_id,
                'expire_date' => $request->expireDate,
                'quantity' => $request->quantity,
                'price' => $request->buy_price,
                'old_stock' => $old_stock_quantity,
                'old_buy_price' => $old_stock_buy_price,
                'user_id' => $request->user_id,
                'created_at' => Carbon::now()
            ]);
            DB::commit();
            return response()->json([
                'res' => $stock,
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), $e->getCode());
            // something went wrong
        }
    }
    
    public function purchase_products(){

        $temp_stocks = DB::table('products_temp_stock')
            ->join('products', 'products.id', '=', 'products_temp_stock.product_id')
            ->where('products_temp_stock.is_deleted', '=', 0)
            ->select('products.*','products_temp_stock.quantity as products_temp_stock_quantity', 'products_temp_stock.total_buy_price as products_temp_stock_total_buy_price', 'products_temp_stock.expire_date as products_temp_stock_expire_date','products_temp_stock.expire_date as expire_date','products_temp_stock.id as products_temp_stock_row_id')
            ->get();
        $temp_stocks_price = DB::table('products_temp_stock')
            ->where('is_deleted', '=', 0)
            ->select(DB::raw('sum(total_buy_price) as total_buy_price'))
            ->first();
        return response(
            [
                'temp_stocks' => $temp_stocks,
                'total_buy_price' => $temp_stocks_price->total_buy_price
            ], 200);
    }

    public function api_realstock_product_lists(Request $request)
    {
        $products = DB::table('products as p')
            ->select('p.id', 'p.name', 'p.slug', 'p.price',  'p.buy_price', 'p.discount', 'p.unit_quantity', 'p.stock_quantity', 'p.featured_image', 'p.gp_image_1', 'p.gp_image_2', 'p.gp_image_3', 'p.gp_image_4', 'p.unit')
            ->where('p.status', '=', '1')
            ->where('p.real_stock', '=', 1);
        if ($request->data) {
            $products->where('p.name', 'like', '%' . $request->data . '%');
            $products->orWhere('p.name_bn', 'like', '%' . $request->data . '%');
            $products->orWhere('p.tags', 'like', '%' . $request->data . '%');
        }
        $products = $products->orderBy('p.id', 'DESC')->paginate(50);

        return response(
            [
                'products' => $products
            ], 200);
    }


    public function api_active_product_lists(Request $request)
    {
        $products = DB::table('products as p')
            ->join('categories as C', 'p.category_id', '=', 'C.id')
            ->join('sub_categories as SC', 'p.sub_category_id', '=', 'SC.id')
            //->join('child_sub_cats as CC','p.child_sub_cats_id','=','CC.id')
            ->select('p.id', 'p.name', 'p.slug', 'p.price', 'p.discount', 'p.unit_quantity', 'p.stock_quantity', 'p.featured_image', 'p.gp_image_1', 'p.gp_image_2', 'p.gp_image_3', 'p.gp_image_4', 'p.unit', 'C.cat_name', 'SC.sub_cat_name')
            ->where('p.status', '=', '1')
            ->where('p.restaurant_id', '=', null)
            ->where('p.category_id', '!=', 14);

        if ($request->data) {
            $products->where('p.name', 'like', '%' . $request->data . '%');
            $products->orWhere('p.name_bn', 'like', '%' . $request->data . '%');
            $products->orWhere('p.tags', 'like', '%' . $request->data . '%');
        }
        $products = $products->orderBy('p.id', 'DESC')->paginate(25);
//            ->get();
        return response(
            [
                'products' => $products
            ], 200);
    }


    public function product_request(Request $request)
    {
        $product = new product_request();
        $product->name = $request->name;
        $product->phone = $request->phone;
        $product->save();
        return response(
            [
                'data' => 'success'
            ], Response::HTTP_CREATED);
    }

    public function vendor_request(Request $request)
    {

        $vendor_request = new vendor_request();
        $vendor_request->message = $request->vendorMessage;
        $vendor_request->phone = $request->vendorphone;
        $vendor_request->save();
        return response(
            [
                'data' => 'success'
            ], Response::HTTP_CREATED);
    }


    public function index()
    {
        return productCollection::collection(product::paginate(50));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search($id)
    {
        $id = trim($id);
        $products = DB::table('products')
            ->where('status', '=', 1)
            ->where('name', 'like', '%' . $id . '%')
            ->orWhere('name_bn', 'like', '%' . $id . '%')
            //->orWhere('slug', 'like', '%' . $id . '%')
            ->orWhere('tags', 'like', '%' . $id . '%')
            ->select('id', 'name', 'name_bn', 'tags', 'price', 'discount', 'unit', 'unit_quantity', 'stock_quantity', 'status', 'category_id', 'sub_category_id', 'child_sub_cats_id', 'brand_id', 'featured_image', 'gp_image_1', 'gp_image_2', 'gp_image_3', 'gp_image_4', 'generic_name', 'strength', 'dosages_description', 'use_for', 'DAR', 'description', 'restaurant_id', 'inactive_search', 'is_featured', 'real_stock')
            //->paginate(15);
            ->get();

        return new searchProductResource($products);

    }

    public function admin_shop_product_search($id)
    {
        $id = trim($id);
        $products = DB::table('shop_products')
//            ->where('shop_products.status', '=', 1)
//            ->where('real_stock', '=', 1)
            ->where('name', 'like', '%' . $id . '%')
            ->orWhere('name_bn', 'like', '%' . $id . '%')
            //->orWhere('slug', 'like', '%' . $id . '%')
            ->orWhere('tags', 'like', '%' . $id . '%')
            ->select('shop_products.*')
            ->get();
        $mainproducts = [];
        foreach ($products as $product) {
            if ($product->status == 1 && $product->real_stock == 1) {
                array_push($mainproducts, $product);
            }
        }
        return new searchProductResource($mainproducts);

    }


    public function shop_product_search($id)
    {
        $id = trim($id);
        $products = DB::table('shop_products')
//            ->where('shop_products.status', '=', 1)
//            ->where('real_stock', '=', 1)
            ->where('name', 'like', '%' . $id . '%')
            ->orWhere('name_bn', 'like', '%' . $id . '%')
            //->orWhere('slug', 'like', '%' . $id . '%')
            ->orWhere('tags', 'like', '%' . $id . '%')
            ->select('shop_products.*')
            ->get();
        $mainproducts = [];
        foreach ($products as $product) {
            if ($product->status == 1 && $product->real_stock == 1) {
                array_push($mainproducts, $product);
            }
        }

        return new searchProductResource($mainproducts);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(productRequest $request)
    {
        $product = new product();
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->color = $request->color;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->quantity = $request->quantity;
        $product->unit = $request->unit;
        $product->status = $request->status;
        $product->user_id = $request->user_id;
        $product->save();
        return response(
            [
                'data' => new productResource($product)
            ], Response::HTTP_CREATED);

        //return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Appproduct $appproduct
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        return new productResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Appproduct $appproduct
     * @return \Illuminate\Http\Response
     */
    public function edit(product $appproduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Appproduct $appproduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, product $product)
    {
        $product->update($request->all());
        return response(
            [
                'data' => new productResource($product)
            ], Response::HTTP_CREATED);
        //return $request->all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Appproduct $appproduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(product $product)
    {
        $product->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
