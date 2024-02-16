<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\delivery_location;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class DeliveryLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function my_delivery(){
        $boys =  DB::table('delivery_mans')
            ->where('status', 1)->get();
        return view('delivery.my-delivery',['boys'=>$boys]);
    }

    public function get_my_delivery($boy_id,$start_date,$end_date){
        $delivery = DB::table('orders')
            ->where('delivered_date', '>=', $start_date . ' 00:00:00')
            ->where('delivered_date', '<=', $end_date . ' 23:59:59')
            ->where('orders.active_status', '=', 3)
            ->where('orders.delivery_man_id', '=', $boy_id)
            ->count();
        return response()->json($delivery);
    }

    public function new_delivery_boy(){
        $boys =  DB::table('delivery_mans')->get();
        return view('delivery.add-delivery-boy',['boys'=>$boys]);
    }

    public function edit_delivery_boy($id){
        $boy =  DB::table('delivery_mans')
            ->where('id',$id)
            ->first();

        return view('delivery.edit',['boy'=>$boy]);
    }
    public function update_delivery_boy(Request $request){
         DB::table('delivery_mans')
            ->where('id', $request->id)
            ->update(['name' => $request->name,'phone' => $request->phone,'status'=>$request->status]);
        return redirect('ad/new-delivery-boy');
    }


    public function save_delivery_boy(Request $request){
        $result =  DB::table('delivery_mans')->insert([
            'name' => $request->name,
            'phone' => $request->phone,
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        if($result == 1){
            $request->session()->flash('status', 'Delivery Boy Added Successfully.');
            return redirect()->back();
        }
    }

    public function index()
    {
        $locations= DB::table('delivery_locations')
         ->select('delivery_locations.id as location_id',
         'delivery_locations.location_name as location_name',
          'delivery_locations.location_name_bn as location_name_bn',
         'delivery_locations.charge as delivery_charge',
             'delivery_locations.extra_fast_delivery_charge',
             'delivery_locations.postcode',
             'delivery_locations.start_time',
             'delivery_locations.end_time',
             'delivery_locations.days',
              'delivery_locations.discount',
             'delivery_locations.water_location_serial',
         'delivery_locations.min_order_amount as min_order_amount'
         )->get();
            
        return view('locations.index',['locations'=>$locations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function new_location()
    {
         return view('locations.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add_location(Request $request)
    {
        
         if($request->day){
           $day = implode(',', $request->day);  
         }else{
            $day = '';
         }
        $location =  new delivery_location();
        //$location->timestamps = false;
        $location->location_name = $request->name;
        $location->location_name_bn = strtolower($request->name_bn);
        $location->charge = $request->charge;
         $location->start_time = $request->start_time;
          $location->end_time = $request->end_time;
           $location->days = $day;
         $location->min_order_amount = $request->min_order_amount;
          $location->postcode = $request->postcode;
           $location->discount = $request->discount;
        $location->save();
        
           if(Auth::user()->role=='admin'){        
        return redirect('ad/locations');
        }elseif(Auth::user()->role=='manager'){
           return redirect('pm/locations');
        }
          
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\delivery_location  $delivery_location
     * @return \Illuminate\Http\Response
     */
    public function show(delivery_location $id)
    {
          return view('locations.edit',['location'=>$id]);
         
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\delivery_location  $delivery_location
     * @return \Illuminate\Http\Response
     */
    public function update_location(Request $request)
    {

         if($request->day){
           $day = implode(',', $request->day);  
         }else{
            $day = '';
         }

           DB::table('delivery_locations')->where('id', $request->id) ->update([
               'water_location_serial' => $request->water_location_serial,
               'start_time' => $request->start_time,
               'end_time' => $request->end_time,
                'discount' => $request->discount,
               'days' => $day,
               'location_name' => $request->name,
                 'location_name_bn' => $request->name_bn, 'postcode' => $request->postcode,'charge'=>$request->charge,'extra_fast_delivery_charge'=>$request->extra_fast_delivery_charge,'min_order_amount'=>$request->min_order_amount]);
      $request->session()->flash('status', ' Updated Successfully');
       
          if(Auth::user()->role=='admin'){        
        return redirect('ad/locations');
        }elseif(Auth::user()->role=='manager'){
           return redirect('pm/locations');
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\delivery_location  $delivery_location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, delivery_location $delivery_location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\delivery_location  $delivery_location
     * @return \Illuminate\Http\Response
     */
    public function destroy(delivery_location $delivery_location)
    {
        //
    }
}