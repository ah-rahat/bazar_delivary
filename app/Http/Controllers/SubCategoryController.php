<?php

namespace App\Http\Controllers;
use Auth;
use App\sub_category;
use App\Category;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use DB;
class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return sub_category::all();  
    }
    public function edit_sub_category($id)
    {
        $category = category::all();
        $sub_category= sub_category::find($id);
        return view('sub_category_edit',['sub_category'=>$sub_category,'category'=>$category]);
    }
    public function update_sub_category(Request  $request)
    {

        $cat_banner_img = $request->file('banner');

        if($cat_banner_img!=''){
            $cat_banner_img_name = time().rand(1, 100000).'.'.$cat_banner_img->getClientOriginalExtension();
            $cat_banner_img->move('uploads/cat_images',$cat_banner_img_name);
         }else{
            $cat_banner_img_name= $request->cat_old_banner_image;
         }


        $cat_img = $request->file('cat_image');

        if($cat_img!=''){
            $cat_img_name = time().rand(1, 100000).'.'.$cat_img->getClientOriginalExtension();
            $cat_img->move('uploads/cat_images',$cat_img_name);
        }else{
            $cat_img_name= $request->subcat_old_image;
        }


       DB::table('sub_categories')->where('id', $request->id)->update(['cat_image' => $cat_img_name,'category_id' => $request->category_id,'banner' => $cat_banner_img_name,'sub_cat_name' => $request->sub_category_name,'sub_cat_name_bn' => $request->sub_cat_name_bn ]);
        $request->session()->flash('status', '  sub Category  update successfully!');

      if(Auth::user()->role=='admin'){
        return redirect('ad/sub-category-lists');
        }elseif(Auth::user()->role=='manager'){
           return redirect('pm/sub-category-lists');
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
     * @param  \App\sub_category  $sub_category
     * @return \Illuminate\Http\Response
     */
    public function show(sub_category $sub_category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\sub_category  $sub_category
     * @return \Illuminate\Http\Response
     */
    public function edit(sub_category $sub_category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\sub_category  $sub_category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, sub_category $sub_category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\sub_category  $sub_category
     * @return \Illuminate\Http\Response
     */
    public function destroy(sub_category $sub_category)
    {
        //
    }
}
