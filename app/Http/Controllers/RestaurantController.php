<?php

namespace App\Http\Controllers;
use App\Category;
 
 
use App\child_sub_cats;
use App\brand;
use App\delivery_man;
use App\offer_image;
use App\order_item;
use App\order;
use App\prescription;
use App\regular_product;
use App\terms_condition;
use App\color;

use  App\product;
use App\sub_category;
use App\restaurant;
use Mail;
use Carbon\Carbon;
use App\unit;
use App\product_requests;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
Use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Yuansir\Toastr\Facades\Toastr;
use  Symfony\Component\HttpFoundation\Response;

class RestaurantController extends Controller
{
     
     
  public function update_food(Request $request)
    { 
        

        $name = $request->name;
        $name_bn = $request->name_bn;
        $price = $request->price;
        $discount = $request->discount;
        $quantity = $request->unit_quantity;
        $stock_quantity = $request->stock_quantity;
        $buy_price = $request->buy_price; 
        $unit = $request->unit;
        $status = $request->status;

        $restaurant_id =$request->restaurant_id;
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

        if($f_image!=''){

            $image=$f_image;
            //unique  file name
            $filename    = time().rand(1, 100000).'.'.$image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
           // Image::make($image_resize)->resize(400, null, function($constraint) {
             //   $constraint->aspectRatio();
            //});
            $image_resize->save('uploads/products/'.$filename);

            //img  file  code  end
            $f_img_name = $filename;
        }else{
            $f_img_name = $old_f_image;
        }

        if($gp_image_1!=''){

            $image=$gp_image_1;
            //img  file  code  START
            //unique  file name
            $filename    = time().rand(1, 100000).'.'.$image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            //Image::make($image_resize)->resize(400, null, function($constraint) {
              //  $constraint->aspectRatio();
            //});
            $image_resize->save('uploads/products/'.$filename);
            //img  file  code  end
            $gp_img_name_1 = $filename;

        }else{
            $gp_img_name_1 = $old_gp_image_1;
        }

        if($gp_image_2!=''){
//            $g_img_name_2 = time().rand(1, 100000).'.'.$gp_image_2->getClientOriginalExtension();
//            $gp_image_2->move('uploads/gallery_images',$g_img_name_2);
//            $gp_img_name_2 = $g_img_name_2;

            $image=$gp_image_2;
            //unique  file name
            //img  file  code  START
            //unique  file name
            $filename    = time().rand(1, 100000).'.'.$image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            //Image::make($image_resize)->resize(400, null, function($constraint) {
              //  $constraint->aspectRatio();
            //});
            $image_resize->save('uploads/products/'.$filename);
            //img  file  code  end
            $gp_img_name_2 = $filename;

        }else{
            $gp_img_name_2 = $old_gp_image_2;
        }
        if($gp_image_3!=''){

            $image=$gp_image_3;
            //img  file  code  START
            //unique  file name
            $filename    = time().rand(1, 100000).'.'.$image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            //Image::make($image_resize)->resize(400, null, function($constraint) {
              //  $constraint->aspectRatio();
            //});
            $image_resize->save('uploads/products/'.$filename);
            //img  file  code  end
            $gp_img_name_3 = $filename;
        }else{
            $gp_img_name_3 = $old_gp_image_3;
        }
        if($gp_image_4!=''){
//            $g_img_name_4 = time().rand(1, 100000).'.'.$gp_image_4->getClientOriginalExtension();
//            $gp_image_4->move('uploads/gallery_images',$g_img_name_4);
//            $gp_img_name_4 = $g_img_name_4;

            $image=$gp_image_4;
            //img  file  code  START
            //unique  file name
            $filename    = time().rand(1, 100000).'.'.$image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            //Image::make($image_resize)->resize(400, null, function($constraint) {
              //  $constraint->aspectRatio();
           // });
            $image_resize->save('uploads/products/'.$filename);
            //img  file  code  end
            $gp_img_name_4 = $filename;
        }else{
            $gp_img_name_4 = $old_gp_image_4;
        }


        DB::table('products')->where('id', $request->id)
            ->update(['name' => $name,'name_bn'=>$name_bn,'price' => $price,'buy_price'=>$buy_price,
            'discount' => $discount,'unit_quantity' => $quantity,'stock_quantity'=>$stock_quantity,
            'unit' => $unit,'description' => $description,'tags'=>$tags,
                'restaurant_id' => $restaurant_id,'brand_id' => $brand_id,
                'featured_image' => $f_img_name,'gp_image_1' => $gp_img_name_1,
                'gp_image_2' => $gp_img_name_2,'gp_image_3' => $gp_img_name_3,'gp_image_4' => $gp_img_name_4,
                'status' =>$status,
            ]);
        $request->session()->flash('status', 'Food Updated successfully!');
        return  redirect()->back(); 
    }
    
     public function update_restaurent(Request $request)
    { 
     
        $restaurant_name_en = $request->restaurant_name_en;
        $restaurant_name_bn = $request->restaurant_name_bn;
        $address_en = $request->address_en;
        $address_bn = $request->address_bn;
        $status = $request->status;
        
        $f_image = $request->file('image');
       
        $old_f_image = $request->old_res_img;
         
        if($f_image!=''){

            $image=$f_image;
            //unique  file name
            $filename    = time().rand(1, 100000).'.'.$image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
           // Image::make($image_resize)->resize(400, null, function($constraint) {
             //   $constraint->aspectRatio();
            //});
            $image_resize->save('uploads/restaurants/'.$filename);

            //img  file  code  end
            $f_img_name = $filename;
        }else{
            $f_img_name = $old_f_image;
        }
 
        DB::table('restaurants')->where('id', $request->id)
            ->update(['restaurant_name_en' => $restaurant_name_en,'restaurant_name_bn'=>$restaurant_name_bn,
            'address_en' => $address_en,'address_bn'=>$address_bn,
            'image' => $f_img_name, 
            'status' =>$status,
            ]);
        $request->session()->flash('status', 'Restaurent Updated successfully!');
        return  redirect()->back(); 
    }
    
     
     
  public function edit_food($id)
    { 
         $restaurants = restaurant::all();    
        $product= product::find($id);   
        $brands = brand::orderBy("brand_name")->get();
        $units = unit::orderBy("unit_name")->get();
        return view('restaurant.edit-food',['units'=>$units,'brands'=>$brands,'product'=>$product,'restaurants'=>$restaurants]);
 
    }
    
        public function get_foods($id)
    { 
         $restaurant=DB::table('restaurants') 
         ->where('restaurants.slug', '=', $id)
         ->first();
 
        $foods=DB::table('products') 
         ->where('products.restaurant_id', '=', $restaurant->id)
         ->where('products.status', '=', 1)
         ->get();
          
         return response()->json([
            'foods' => $foods,
            'restaurant' =>$restaurant
         ]);  
             
    }

    public function vendor_food_lists()
    {
        $userId = Auth::id();
        $foods=DB::table('products')
            ->where('products.restaurant_id', '!=', '')
            ->where('products.user_id', '=', $userId)
            ->join('restaurants', 'restaurants.id', '=', 'products.restaurant_id')
            ->select('products.*','restaurants.restaurant_name_en','restaurants.restaurant_name_bn')
            ->orderBy('products.id', 'DESC')
            ->get();

        return view('restaurant.vendor-food-list',['products'=>$foods]);

    }

     public function food_lists()
    {
         
        $foods=DB::table('products') 
         ->where('products.restaurant_id', '!=', '')
           ->join('restaurants', 'restaurants.id', '=', 'products.restaurant_id')
           ->select('products.*','restaurants.restaurant_name_en','restaurants.restaurant_name_bn')
            ->orderBy('products.id', 'DESC')
         ->get();
       
        return view('restaurant.food-list',['products'=>$foods]);
 
    }
    
    
     public function food_form()
    {
        $restaurants = restaurant::all();    
        $units = unit::all();
        $brands = brand::all();
        return view('restaurant.add-food',['units'=>$units,'restaurants'=>$restaurants,'brands'=>$brands]);
 
    }
    
        public function create_food(Request $request)
    {  
        
        $userId = Auth::id();
        $product =  new product();
        $slug = Str::slug($request->name, '-');
        $data['data'] = DB::table('products')->where('slug', $slug)->first();
        if(count($data)>0){
            $slug= $slug.'-'.rand(1,300);
        }else{
            $slug=$slug;
        }
        //featured  image
        $f_image = $request->file('featured_img');
        if($f_image!=''){
            $image=$f_image;
            //unique  file name
            $filename    = time().rand(1, 100000).'.'.$image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            //Image::make($image_resize)->resize(400, null, function($constraint) {
              //  $constraint->aspectRatio();
            //});
            $image_resize->save('uploads/products/'.$filename);
            $product->featured_image = $filename;
        }else{
            $product->featured_image = '';
        }

        $gp_image=$request->gallery_img;
        if($gp_image!=''){
          $count = count($gp_image);
            //gallery image
       for($n=0; $n<$count; $n++){
           $a =$n+1; 
           $image= $gp_image[$n];;
           //unique  file name
           $filename    = time().rand(1, 100000).'.'.$image->getClientOriginalExtension();
           $image_resize = Image::make($image->getRealPath()); 
           $image_resize->save('uploads/products/'.$filename); 
           $db_field_name = "gp_image_".$a;
           $product->$db_field_name = $filename;
       }
        }

        $product->name = $request->name;
        $product->name_bn = $request->name_bn;
        $product->tags = $request->tags;
        $product->brand_id = $request->brand_id;
        $product->description = $request->description;
        $product->slug = $slug; 
        $product->restaurant_id = $request->restaurant_id; 
        $product->price = $request->price;
        $product->buy_price = $request->buy_price;
        $product->discount = $request->discount;
        $product->unit_quantity = $request->unit_quantity;
        $product->stock_quantity = $request->stock_quantity;
        $product->unit = $request->unit;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->user_id = $userId;
        $product->save();
        $request->session()->flash('status', ' New Food  added successfully!');
        return  redirect()->back();
    }
                   
    public function index()
    {
        return view('restaurant.create');
    }
    
    
    
    
    
    
      public function create(Request $request)
    {
         
        $userId = Auth::id();
        $restaurant =  new restaurant();
        $restaurant->restaurant_name_en = $request->restaurant_name_en;
        $restaurant->restaurant_name_bn = $request->restaurant_name_bn;
        $restaurant->address_en = $request->address_en;
        $restaurant->address_bn = $request->address_bn;
        
        $res_img = $request->file('image');
        
            $image=$res_img;
            //img  file  code  START
            //unique  file name
            $filename    = time().rand(1, 100000).'.'.$image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
           
            $image_resize->save('uploads/restaurants/'.$filename);
            //img  file  code  end
 

        $slug = Str::slug($request->restaurant_name_en, '-');
        $restaurant->slug = $slug; 
        $restaurant->image = $filename;  
        $restaurant->save();
        $request->session()->flash('status', ' New Restaurant  added successfully!');
        return  redirect()->back(); 
        
    }
    
  public function  lists()
  {
   $restaurants=DB::table('restaurants')
           ->orderBy('restaurants.id', 'DESC')
            ->get();
    return view('restaurant.index',['restaurants'=>$restaurants]);
    
  }
    
   public function  show($id)
  {
    $single=DB::table('restaurants')->where('id', $id)->first(); 
 
    return view('restaurant.edit_res',['single'=>$single]);
    
  } 
    
    public function  all_restaurants()
  {
    $restaurants=DB::table('restaurants')
        ->where('status', 1)
        ->get();
    
      return response(
        [
           'data' =>  $restaurants
        ],Response::HTTP_CREATED);
    
  }  
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

}
