<?php

namespace App\Http\Controllers;
use App\sub_category;
use App\child_sub_cats;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
Use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class ChildSubCatsController extends Controller
{
     public function __construct()
    {
        //$this->middleware('auth');
    }
    
    public function show_child_categorie()
    {
      return child_sub_cats::all();
    
    }   
    
      public function index()
    {
      $sub_category = sub_category::all();
      return view('childcat.index',['sub_category'=>$sub_category]);
    }   
   
    public function create(Request $request)
    {
        $cat_banner = $request->file('cat_img');

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
        $userId = Auth::id();
        $child_category =  new child_sub_cats();
        $child_category->child_cat_name = $request->child_cat_name;
        $child_category->child_cat_name_bn = $request->child_cat_name_bn;
        $slug = Str::slug($request->child_cat_name, '-');
        $child_category->slug = $slug;
         $child_category->sub_category_id = $request->sub_category_id;
        $child_category->user_id = $userId;
        $child_category->cat_image = $banner_filename;
        $child_category->save();
        $request->session()->flash('status', ' New Child Category  added successfully!');
        
        if(Auth::user()->role=='admin'){        
        return redirect('ad/child-category');
        }elseif(Auth::user()->role=='manager'){
           return redirect('pm/child-category');
        }
        
    }
    //Show List
     public function child_category_lists()
    {
        $child_lists = child_sub_cats::all();
        return view('childcat.list',['child_lists'=>$child_lists]);
    }

    public function edit_child_category($id)
    {
        $sub_category = sub_category::all();
        $child_cat = child_sub_cats::find($id);
        return view('childcat.child_category_edit',['sub_category'=>$sub_category,'child_cat'=>$child_cat]);
    }


public function update_child_category(Request  $request)
{
    $cat_banner_img = $request->file('cat_image');

    if($cat_banner_img!=''){
        $cat_banner_img_name = time().rand(1, 100000).'.'.$cat_banner_img->getClientOriginalExtension();
        $cat_banner_img->move('uploads/cat_images',$cat_banner_img_name);
    }else{
        $cat_banner_img_name= $request->childcat_old_image;
    }
    DB::table('child_sub_cats')->where('id', $request->id)->update(['cat_image' => $cat_banner_img_name,'sub_category_id' => $request->sub_category_id,'child_cat_name' => $request->child_cat_name,'child_cat_name_bn' => $request->child_cat_name_bn ]);
    $request->session()->flash('status', '  sub Category  update successfully!');
     
     if(Auth::user()->role=='admin'){        
        return redirect('ad/child-cat-list');
        }elseif(Auth::user()->role=='manager'){
           return redirect('pm/child-cat-list');
        }

}

}
