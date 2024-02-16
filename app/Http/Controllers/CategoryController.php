<?php

namespace App\Http\Controllers;
use App\Category;
use App\Http\Resources\category\CategoryResource;
use App\Http\Resources\category\categoryProductResource;
use App\sub_category;
use App\child_sub_cats;
use App\delivery_location;
use App\prescription;
use Illuminate\Http\Request;
use App\offer_image; 
use Auth;
//for  upload image  use this  one
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class CategoryController extends Controller
{

  public function delivery_slot_update($order_id,$time_slot){

     $res = DB::table('shippings')->where('order_id', $order_id)->update(['delivery_time' => $time_slot]);

      return $res;
  }

    public function banner(){

        $res = DB::table('banners')->get();

        return $res;
    }

  public function delivery_slot($order_id){
      $delivery_slots = DB::table('shippings')
          ->where('shippings.order_id', '=', $order_id)
          ->join('delivery_locations', 'delivery_locations.id', '=', 'shippings.area_id')
          ->select('delivery_locations.delivery_time_slot','shippings.order_id')
          ->first();
      return response()->json([
          'delivery_slots' => $delivery_slots->delivery_time_slot,
          'order_id' => $delivery_slots->order_id
      ]);
  }
  public function upload_prescription(Request $request)
  {

      $request->validate([
          'file' =>  'required|mimes:jpeg,png,jpg,zip,pdf,txt|max:8048',
      ]);

      $image=$request->file;
    $filename = time().rand(1, 100000).'.'.$image->getClientOriginalExtension();
    $image_resize = Image::make($image->getRealPath());
    $image_resize->save('uploads/prescription/'.$filename);
 
     DB::table('prescriptions')->insert(
        ['phone' => $request->phone, 'user_id' =>$request->user_id,'file'=>$filename,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]
     );
 return response()->json([
    'status' => 1
]); 
      
        
  }
    public function featured() {
        $featured =  DB::select(DB::raw("SELECT `id`, `name`, `name_bn`, `tags`, `price`, `discount`, `unit`, `unit_quantity`, `stock_quantity`, `status`, `category_id`, `sub_category_id`, `child_sub_cats_id`, `brand_id`, `featured_image`, `gp_image_1`, `gp_image_2`, `gp_image_3`, `gp_image_4`, `generic_name`, `strength`, `dosages_description`, `use_for`, `DAR`, `description`, `restaurant_id`, `inactive_search`, `is_featured` FROM products WHERE  status=1 AND is_featured =1 AND  stock_quantity > 0 ORDER BY RAND()  LIMIT 40"));
        return response()->json([
            'featured_products' => $featured
        ]);
    }

    public function all_categories() {
            return Category::with('sub_category.child_sub_cats')
             ->orderBy('categories.cat_order')
            ->get();


    }
     public function all_locations_previous_address_used($userid){

         $previous_orders=DB::table('orders')
             ->where('orders.customer_id', '=', $userid)
             ->select('orders.id as order_id')
             ->orderBy('orders.id', 'desc')
             ->limit(3)
             ->get();
         $arr = [];
         foreach($previous_orders as $row)
         {
             $arr[] =  $row->order_id;
         }
         $previous_locations =DB::table('shippings')
             ->whereIn('order_id', $arr)
             ->select('shippings.address as shipping_address')
             ->groupBy('shippings.address')
             ->get();

         $previous_area=DB::table('orders')
             ->join('shippings', 'shippings.order_id', '=', 'orders.id')
             ->where('orders.customer_id', '=', $userid)
             ->select('shippings.area as area')
             ->orderBy('orders.id', 'DESC')
             ->first();
          
          
          $locations= DB::table('delivery_locations')
         ->select('delivery_locations.id as location_id',
         'delivery_locations.location_name as location_name',
         'delivery_locations.location_name_bn as location_name_bn',
         'delivery_locations.charge as delivery_charge',
          'delivery_locations.extra_fast_delivery_charge',
          'delivery_locations.min_order_amount as min_order_amount',
             'delivery_locations.delivery_time_slot',
             'delivery_locations.buffering_time_slot'
         ) ->orderBy('delivery_locations.location_name')
         ->get();
        
     return response()->json([
         'previous_locations' => $previous_locations,
         'previous_area' => $previous_area,
         'locations' => $locations

]);
                          
    }
    
       public function all_delivery_locations(){
          
          $offer=DB::table('offer_images')->where('id', 1)->first();
         
          $locations= DB::table('delivery_locations')
         ->select('delivery_locations.id as location_id',
         'delivery_locations.location_name as location_name',
         'delivery_locations.location_name_bn as location_name_bn',
         'delivery_locations.min_order_amount as min_order_amount',
             'delivery_locations.extra_fast_delivery_charge',
             'delivery_locations.charge as delivery_charge',
             'delivery_locations.delivery_time_slot',
             'delivery_locations.buffering_time_slot',
             'delivery_locations.postcode'
            
         ) ->groupBy('delivery_locations.location_name')
         ->get();
          $message=DB::table('deposit_message')
              ->where('deposit_message.id', '=',2)
              ->first();

        return response()->json([
            'locations' => $locations,
            'offer' => $offer,
            'affiliate_offer' => $message,
        ]);

         
         }
      public function postcode(){
          
          $offer=DB::table('offer_images')->where('id', 1)->first();
         
          $locations= DB::table('delivery_locations')
         ->select('delivery_locations.id as location_id',
         'delivery_locations.location_name as location_name',
         'delivery_locations.location_name_bn as location_name_bn',
         'delivery_locations.min_order_amount as min_order_amount',
             'delivery_locations.extra_fast_delivery_charge',
             'delivery_locations.charge as delivery_charge',
             'delivery_locations.delivery_time_slot',
             'delivery_locations.buffering_time_slot',
             'delivery_locations.postcode'
            
         ) ->orderBy('delivery_locations.location_name')
         ->get();
          $message=DB::table('deposit_message')
              ->where('deposit_message.id', '=',2)
              ->first();

        return response()->json([
            'locations' => $locations,
            'offer' => $offer,
            'affiliate_offer' => $message,
        ]);

         
         }
      public function all_locations(){
         
          return DB::table('delivery_locations')
         ->select('delivery_locations.id as location_id',
         'delivery_locations.location_name as location_name',
         'delivery_locations.location_name_bn as location_name_bn',
         'delivery_locations.charge as delivery_charge',
         'delivery_locations.min_order_amount as min_order_amount'
            
         ) ->orderBy('delivery_locations.location_name_bn')
         ->get();
         }
         
      public function all_category(){
           $categories=DB::table('categories')
         ->select(
         'categories.id as category_id',
         'categories.cat_name as category_name',
         'categories.cat_name_bn as cat_name_bn',
          'categories.cat_img as category_img',
          'categories.cat_icon as category_icon',
         'categories.slug as category_slug'
         )->get();
         
        $sub_categories=DB::table('sub_categories')
        ->select(
        'sub_categories.id as sub_category_id',
        'sub_categories.sub_cat_name as sub_category_name',
        'sub_categories.sub_cat_name_bn as sub_cat_name_bn',
        'sub_categories.slug  as sub_category_slug',
        'sub_categories.category_id  as category_id'
        )->get();

        
         $child_sub_categories=DB::table('child_sub_cats')
         ->select(
         'child_sub_cats.id  as child_category_id',
         'child_sub_cats.sub_category_id  as sub_category_id',
         'child_sub_cats.child_cat_name  as child_category_name',
          'child_sub_cats.child_cat_name_bn  as child_cat_name_bn',
         'child_sub_cats.slug  as child_category_slug'
      
         )->get();
              
        $categories = [json_decode(json_encode($categories),true)]; //it will return you data in array
        $sub_categories = [json_decode(json_encode($sub_categories),true)]; //it will return you data in array
        $child_sub_categories = [json_decode(json_encode($child_sub_categories),true)]; //it will return you data in array
        $all=array_merge($categories,$sub_categories,$child_sub_categories);

         return new CategoryResource($all);
      }
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return Category::all();
    }
    public function edit_category($id)
    {
        $category= Category::find($id);
        return view('category-edit',['category'=>$category]);
    }
    public function update_category(Request  $request)
    {
        
        $cat_img = $request->file('cat_img');
        $cat_banner_img = $request->file('cat_banner_img');
        $cat_icon = $request->file('cat_icon');
       
        if($cat_banner_img!=''){
            $cat_banner_img_name = time().rand(1, 100000).'.'.$cat_banner_img->getClientOriginalExtension();
            $cat_banner_img->move('uploads/cat_images',$cat_banner_img_name);
         }else{
            $cat_banner_img_name= $request->cat_old_banner_image;
         }
         
         
         if($cat_img!=''){
            $cat_img_name = time().rand(1, 100000).'.'.$cat_img->getClientOriginalExtension();
            $cat_img->move('uploads/cat_images',$cat_img_name);
         }else{
            $cat_img_name= $request->cat_old_img;
         }
         
          if($cat_icon!=''){
            $cat_icon_name = time().rand(1, 100000).'.'.$cat_icon->getClientOriginalExtension();
            $cat_icon->move('uploads/cat_images',$cat_icon_name);
         }else{
            $cat_icon_name=$request->cat_old_icon;
         }
          
            DB::table('categories')->where('id', $request->id)->update(['cat_name' => $request->cat_name,'cat_name_bn' => $request->cat_name_bn,'cat_img' => $cat_img_name,'cat_banner_img' =>$cat_banner_img_name,'cat_icon' => $cat_icon_name,  'cat_order' => $request->order]);
        
        $request->session()->flash('status', '   Category  update successfully!');
         
        if(Auth::user()->role=='admin'){        
        return redirect('ad/category-lists');
        }elseif(Auth::user()->role=='manager'){
           return redirect('pm/category-lists');
        }

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
        public function test_pagi($id)
    {
        
        
        
         $category=DB::table('categories')
         ->select('categories.id as category_id')
         ->where('categories.slug', '=', $id)
         ->count();
          $sub_category=DB::table('sub_categories')
           ->select('sub_categories.id as sub_category_id')
          ->where('sub_categories.slug', '=', $id)
          ->count();
           $child_sub_category=DB::table('child_sub_cats')
           ->select('child_sub_cats.id as child_sub_category_id')
          ->where('child_sub_cats.slug', '=', $id)
          ->count();
         if($category==1){
            $category=DB::table('categories')
           ->select('categories.id as category_id')
           ->where('categories.slug', '=', $id)
           ->first();
          return  $category_products=DB::table('products')
                  ->where('products.category_id', '=', $category->category_id)
                   ->where('status', '1')
                   ->orderBy('name')
                 ->paginate(15);  
       //return $category_products=Category::with('products')->find($category->category_id);
         
       }elseif($sub_category==1){
          $sub_category=DB::table('sub_categories')
           ->select('sub_categories.id as sub_category_id')
          ->where('sub_categories.slug', '=', $id)
          ->first();
return  DB::table('products')
->where('products.sub_category_id', '=', $sub_category->sub_category_id)
    ->where('status', '1')
     ->orderBy('name')
  ->paginate(15);  
          
          
         //return  $category_products=sub_category::with('products')->find($sub_category->sub_category_id);
           
       }elseif($child_sub_category==1){
          $child_sub_category=DB::table('child_sub_cats')
           ->select('child_sub_cats.id as child_sub_category_id')
          ->where('child_sub_cats.slug', '=', $id)
          ->first(); 
          
          return  DB::table('products')
->where('products.child_sub_cats_id', '=', $child_sub_category->child_sub_category_id)
    ->where('status', '1')
     ->orderBy('name')
  ->paginate(15);  
  }
     
    }
    public function show($id)
    {
        if($id==='discounted-products'){
            return DB::table('products')
              ->where('products.restaurant_id', '=', null)
              ->where('products.category_id', '!=', 14)  
            ->where('products.discount', '>', 0) 
               ->where('products.status', '=', 1) 
               ->where('products.stock_quantity', '>', 0)
               ->select('id', 'name', 'name_bn', 'tags', 'price', 'discount', 'unit', 'unit_quantity', 'stock_quantity', 'status', 'category_id', 'sub_category_id', 'child_sub_cats_id', 'brand_id', 'featured_image', 'gp_image_1', 'gp_image_2', 'gp_image_3', 'gp_image_4', 'generic_name', 'strength', 'dosages_description', 'use_for', 'DAR', 'description', 'restaurant_id', 'inactive_search', 'is_featured')
         ->get();
        }else{
             
         $category=DB::table('categories')
         ->select('categories.id as category_id')
         ->where('categories.slug', '=', $id)
         ->count();
          $sub_category=DB::table('sub_categories')
           ->select('sub_categories.id as sub_category_id')
          ->where('sub_categories.slug', '=', $id)
          ->count();
           $child_sub_category=DB::table('child_sub_cats')
           ->select('child_sub_cats.id as child_sub_category_id')
          ->where('child_sub_cats.slug', '=', $id)
          ->count();
         if($category==1){
            $category=DB::table('categories')
           ->select('categories.id as category_id','categories.cat_banner_img as cat_banner_img')
           ->where('categories.slug', '=', $id)
           ->first();
           
           
         $products =   DB::select(DB::raw("SELECT `id`, `name`, `name_bn`, `tags`, `price`, `discount`, `unit`, `unit_quantity`, `stock_quantity`, `status`, `category_id`, `sub_category_id`, `child_sub_cats_id`, `brand_id`, `featured_image`, `gp_image_1`, `gp_image_2`, `gp_image_3`, `gp_image_4`, `generic_name`, `strength`, `dosages_description`, `use_for`, `DAR`, `description`, `restaurant_id`, `inactive_search`, `is_featured` FROM products WHERE CONCAT(',', category_id, ',') LIKE '%,$category->category_id,%' AND status=1 ORDER BY `name`"));
             $categories=DB::table('sub_categories')
                 ->where('sub_categories.category_id', '=',  $category->category_id)
                 ->get();

             return response()->json([
                 'products' => $products,
                 'categories' => $categories,
                 'banner' => $category->cat_banner_img,
                 'scope' => 'sub',
             ]);

       }elseif($sub_category==1){
          $sub_category=DB::table('sub_categories')
           ->select('sub_categories.id as sub_category_id','sub_categories.banner as cat_banner_img')
          ->where('sub_categories.slug', '=', $id)
          ->first();

             $products =  DB::select(DB::raw("SELECT `id`, `name`, `name_bn`, `tags`, `price`, `discount`, `unit`, `unit_quantity`, `stock_quantity`, `status`, `category_id`, `sub_category_id`, `child_sub_cats_id`, `brand_id`, `featured_image`, `gp_image_1`, `gp_image_2`, `gp_image_3`, `gp_image_4`, `generic_name`, `strength`, `dosages_description`, `use_for`, `DAR`, `description`, `restaurant_id`, `inactive_search`, `is_featured` FROM products WHERE CONCAT(',', sub_category_id, ',') LIKE '%,$sub_category->sub_category_id,%' AND status=1 ORDER BY `name`"));
             $categories=DB::table('child_sub_cats')
                 ->where('child_sub_cats.sub_category_id', '=',  $sub_category->sub_category_id)
                 ->get();

             return response()->json([
                 'products' => $products,
                 'categories' => $categories,
                   'banner' => $sub_category->cat_banner_img,
                 'scope' => 'child',
             ]);
          //$category_products=  DB::select(DB::raw("SELECT * FROM products WHERE CONCAT(',', sub_category_id, ',') LIKE '%,$sub_category->sub_category_id,%' AND status=1 ORDER BY `name`"));
          // return response()->json([
            //     'products' => $category_products,
              //  'cat_banner_image' => $sub_category->cat_banner_img
             //]);
           
       }elseif($child_sub_category==1){
          $child_sub_category=DB::table('child_sub_cats')
           ->select('child_sub_cats.id as child_sub_category_id')
          ->where('child_sub_cats.slug', '=', $id)
          ->first();

             $products =    DB::select(DB::raw("SELECT `id`, `name`, `name_bn`, `tags`, `price`, `discount`, `unit`, `unit_quantity`, `stock_quantity`, `status`, `category_id`, `sub_category_id`, `child_sub_cats_id`, `brand_id`, `featured_image`, `gp_image_1`, `gp_image_2`, `gp_image_3`, `gp_image_4`, `generic_name`, `strength`, `dosages_description`, `use_for`, `DAR`, `description`, `restaurant_id`, `inactive_search`, `is_featured` FROM products WHERE CONCAT(',', child_sub_cats_id, ',') LIKE '%,$child_sub_category->child_sub_category_id,%' AND status=1 ORDER BY `name`"));

             return response()->json([
                 'products' => $products,
                 'categories' => [],
             ]);
         // $category_products=  DB::select(DB::raw("SELECT * FROM products WHERE CONCAT(',', child_sub_cats_id, ',') LIKE '%,$child_sub_category->child_sub_category_id,%' AND status=1 ORDER BY `name`"));
 // return response()->json([
    //             'products' => $category_products,
      ///          'cat_banner_image' => ''
         //    ]);
 
  }
 
        
          
  //$url_string =$id;
//    
//    if(strpos($url_string, "mc=") !== false){
//        $main_cat = explode('mc=', $url_string);
//        return  $category_products=Category::with('products')->find($main_cat->category_id);        
//    }    
//    elseif(strpos($url_string, "sc=") !== false){
//        $sub_cat = explode('sc=', $url_string);
//        return $category_products=sub_category::with('products')->find($sub_cat->sub_category_id);
//    } elseif(strpos($url_string, "cc=") !== false){
//        $child_cat = explode('cc=', $url_string);
//        return $category_products=child_sub_cats::with('products')->find($child_cat->child_sub_category_id);
//    }  

     }
    }
  
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}