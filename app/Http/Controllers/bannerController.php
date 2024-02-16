<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\banner;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
Use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
class bannerController extends Controller
{
    
    
      public function get_list()
    {    
        $banners=  DB::table('banners')  
          ->select('banners.type as type','banners.banner_image as banner_image')
          ->get();
         return $banners;
    }
    public function banner_show($name)
    {
//        $banners=  DB::table('banners')
//            ->select('banners.type as type','banners.banner_image as banner_image')
//            ->get();
        $sub_category=DB::table('sub_categories')
            ->where('slug', '=', $name)
            ->first();
        if($sub_category){
            $category=DB::table('categories')
                ->where('id', '=', $sub_category->category_id)
                ->first();

            return response()->json([
              'data' => $category->cat_banner_img,
             ]);
        }else{
            $child_sub_category=DB::table('child_sub_cats')
                ->where('slug', '=', $name)
                ->first();

            if($child_sub_category->sub_category_id){
                $sub_category=DB::table('sub_categories')
                    ->where('id', '=', $child_sub_category->sub_category_id)
                    ->first();
                $category=DB::table('categories')
                    ->where('id', '=', $sub_category->category_id)
                    ->first();
                return response()->json([
                    'data' => $category->cat_banner_img,
                ]);
            }
        }

    }

      public function get_terms()
    {    
        $term=DB::table('terms_conditions')  
          ->select('terms_conditions.description as description')
          ->get();
         return $term;
    }
    
    
     public function index()
    {    
        $banners=  DB::table('banners')->get();
         return view('banner.index',['banners'=>$banners]);
    }
    
       public function store()
    {    
         return view('banner.create');
    }
     public function delete($id)
    {    
         DB::table('banners')->delete($id);
          return redirect()->back();
    }
      public function create_banner(Request $request)
    {
        $banner=  new banner();
        $banner->type = $request->type;
        $banner_img = $request->file('banner_img');
        if($banner_img!=''){
            $image=$banner_img;
            //img  file  code  START
            $filename    = time().rand(1, 100000).'.'.$image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
//            Image::make($image_resize)->resize(400, null, function($constraint) {
//                $constraint->aspectRatio();
//            });
            $image_resize->save('uploads/banner_images/'.$filename);
            //img  file  code  end
        }else{
            $filename='';
        }
        $banner->banner_image = $filename;
        $banner->link = $request->link;
        $banner->save();
        $request->session()->flash('status', ' New Banner  added successfully!');
       
          if(Auth::user()->role=='admin'){        
        return redirect('ad/banner');
        }elseif(Auth::user()->role=='manager'){
           return redirect('pm/banner');
        }
        
    }
      
    
}
