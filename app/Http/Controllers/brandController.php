<?php

namespace App\Http\Controllers;
use App\brand;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use DB;
use Auth;
class brandController extends Controller
{
    
      public function delete_brand($id){
    $res=DB::table('brands')->where('id', $id)->delete();
   return redirect()->back();
      }
    

    public function product_lock(Request $request){
        $product_id =$request->product_id;
        $confirm_product_id =$request->confirm_product_id;
        if($confirm_product_id == $product_id){
            $update = DB::table('products')->where('id', $product_id)->update(
                [
                    'real_stock' => 1,
                ]);
            $request->session()->flash('lockstatus', 'Product Locked Successfully.');
            return redirect()->back();
        }else{
            $request->session()->flash('locerror', 'Product ID  does  not Match.');
            return redirect()->back();
        }
    }


    public function stock_history_clean(Request $request){
        $product_id =$request->product_id;
        $confirm_product_id =$request->confirm_product_id;
        if($confirm_product_id == $product_id){
            $update = DB::table('products')->where('id', $product_id)->update(
                [
                    'real_stock' => 0,
                ]);
            $item = DB::table('product_stocks')
                ->where('product_id', '=', $product_id)
                ->delete();
            $request->session()->flash('status', 'History Clean Successfully & Unlocked.');
            return redirect()->back();
        }else{
            $request->session()->flash('error', 'Product ID  does  not Match.');
            return redirect()->back();
        }
    }

    public function stock_history(){
        return view('products.clear-history');
    }

    public function index()
    {
        return view('brand');
    }
    public function create_brand(Request $request)
    {
        $brand=  new brand();
        $brand->brand_name = $request->brand_name;
        $brand->brand_name_bn = $request->brand_name_bn;
        $brand_img = $request->file('brand_img');
        if($brand_img!=''){
            $image=$brand_img;
            //img  file  code  START
            $filename    = time().rand(1, 100000).'.'.$image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            Image::make($image_resize)->resize(400, null, function($constraint) {
                $constraint->aspectRatio();
            });
            $image_resize->save('uploads/brand_images/'.$filename);
            //img  file  code  end
        }else{
            $filename='';
        }
        $brand->brand_img = $filename;
        $brand->save();
        $request->session()->flash('status', ' New Brand  added successfully!');
       
          if(Auth::user()->role=='admin'){        
        return redirect('ad/brand');
        }elseif(Auth::user()->role=='manager'){
           return redirect('pm/brand');
        }
        
    }
    public function brand_lists()
    {
        $brands = brand::all();
        return view('brand-list',['brands'=>$brands]);
    }
    public function edit_brand($id)
    {
        $brand= brand::find($id);
        return view('brand-edit',['brand'=>$brand]);
    }

    public function update_brand(Request  $request)
    {

        $brand_img = $request->file('brand_img');
        if($brand_img!=''){
            $brand_img_name = time().rand(1, 100000).'.'.$brand_img->getClientOriginalExtension();
            $brand_img->move('uploads/brand_images',$brand_img_name);
            DB::table('brands')->where('id', $request->id)->update(['brand_name' => $request->brand_name,'brand_name_bn' => $request->brand_name_bn,'brand_img' => $brand_img_name]);
        }else{
            DB::table('brands')->where('id', $request->id)->update(['brand_name' => $request->brand_name,'brand_name_bn' => $request->brand_name_bn]);
        }
        $request->session()->flash('status', '   Category  update successfully!');
     
         if(Auth::user()->role=='admin'){        
        return redirect('ad/brand-lists');
        }elseif(Auth::user()->role=='manager'){
           return redirect('pm/brand-lists');
        }
    }

}
