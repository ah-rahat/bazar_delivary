<?php

namespace App\Http\Controllers;
use App\Category;
use App\attendance;
use App\Http\Resources\category\CategoryResource;
use App\Http\Resources\category\categoryProductResource;
use App\sub_category;
use App\child_sub_cats;
use App\delivery_location;
use App\prescription;
use Illuminate\Http\Request;
use App\offer_image;

use Auth;
use  Illuminate\Support\Facades\Redirect;
//for  upload image  use this  one
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class AttendanceController extends Controller
{
  public function index()
  {
      $emp = DB::table('employees')
          ->where('status', '=',  1)
          ->get();

      return view('attendance.index',['employees'=>$emp]);

  }

    public function update_employee(Request $request){
        $res = DB::table('employees')
            ->where([
                'id' => $request->id,
            ])
            ->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'status' => $request->status,
                'salary' => $request->salary,
                'hourly_bill' => $request->hourly_bill,
                'updated_at' =>  now()
            ]);
        $request->session()->flash('status', 'Updated Successfully');
        return redirect()->back();
    }
    public function edit_employee($id){
        $emp = DB::table('employees')
            ->where('id', '=',  $id)
            ->first();
        return view('employee.edit-employee',['emp'=>$emp]);
    }

    public function save_employee(Request $request){

        DB::table('employees')->insert([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'join_date' => date('Y-m-d '),
            'status' => 1,
            'salary' => $request->salary,
            'hourly_bill' => $request->hourly_bill,
            'created_at' =>  now(),
            'updated_at' =>  now()
        ]);
        $request->session()->flash('status', 'Added Successfully');
        return redirect()->back();
    }

    public function parameter(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            return Redirect::to('/ad/sheet/'.$request->id.'/'.$request->year.'/'.$request->month);
        } elseif (Auth::user()->role == 'manager') {
            return Redirect::to('/pm/sheet/'.$request->id.'/'.$request->year.'/'.$request->month);
        }


    }

    public function update_sheet(Request $request)
    {

        $count =  DB::table('attendances')
            ->where('date', '=',  $request->year.'-'.$request->month.'-'.$request->day)
            ->where('month', '=',  $request->month)
            ->where('user_id', '=',  $request->emp_id)
            ->where('year', '=',  $request->year)
            ->count();

         if($count ==1){

             if($request->status) {
                 $res = DB::table('attendances')
                     ->where([
                         'user_id' => $request->emp_id,
                         'date' => $request->year . '-' . $request->month . '-' . $request->day
                     ])
                     ->update([
                         'status' => $request->status,
                         'overtime' => $request->overtime,
                         'late' => $request->late,
                         'comment' => $request->comment
                     ]);
             }else{
                 $res = DB::table('attendances')
                     ->where([
                         'user_id' => $request->emp_id,
                         'date' => $request->year.'-'.$request->month.'-'.$request->day
                     ])
                     ->update([
                     'overtime' => $request->overtime,
                     'late' => $request->late,
                     'comment' => $request->comment
                 ]);
             }


             if($res == 1){
                 return response()->json(['success' => 'updated'], 200);
             }
         }else{

             $res = DB::table('attendances')->insert([
                 'user_id' => $request->emp_id,
                 'date' => $request->year.'-'.$request->month.'-'.$request->day,
                 'month' => $request->month,
                 'year' => $request->year,
                 'status' => $request->status,
                 'overtime' => $request->overtime,
                 'late' => $request->late,
                 'comment' => $request->comment,
                 'added_by' =>   Auth::id(),
                 'created_at' =>  now(),
                 'updated_at' =>  now()
             ]);
             if($res == 1){
                 return response()->json(['success' => $request->status], 200);
             }
         }


    }

    public function generate_sheet($emp_id,$year,$month)
    {
        //calculate total days  this  month
        $days=cal_days_in_month(CAL_GREGORIAN,$month,$year);

        $present_days = DB::table('attendances')
            ->where( 'user_id', '=', $emp_id)
            ->where( 'month', '=',$month)
            ->where( 'year', '=',$year)
            ->where( 'status', '!=','A')
            ->select(DB::raw('COUNT(*) as days'),DB::raw('SUM(overtime) AS overtime'),DB::raw('SUM(late) AS late'))
            ->first();
        $salery_amount = DB::table('employees')
            ->where( 'id', '=', $emp_id)
            ->first();
        $single_day_salary = $salery_amount->salary/$days;
        $extra_workhour = $present_days->overtime - $present_days->late;
        $hourbill = $salery_amount->hourly_bill * $extra_workhour ;
        $this_month_salary = $single_day_salary * $present_days->days + $hourbill;

            $data = [];


       for ($x = 1; $x <= $days; $x++) {
            $attendances = DB::table('attendances')
                ->where( 'user_id', '=', $emp_id)
                ->where( 'date', '=', $year.'-'.$month.'-'.$x)
                ->first();
            if($attendances){
                array_push($data,$attendances);
            }else{
                array_push($data,
                    (object) [
                    'date' => $year.'-'.$month.'-'.$x,
                    'status' => null,
                    'overtime' => null,
                    'late' => null,
                    'comment' => null,
                    'month' => $month,
                    'year' => $year,
                    ]);
            }

        }

        $emp = DB::table('employees')
            ->where( 'employees.id', '=', $emp_id)
            ->first();
        $attendances = DB::table('attendances')
            ->where( 'user_id', '=', $emp_id)
            ->where( 'month', '=', $month)
            ->where( 'year', '=', $year)
            ->get();
        $employees = DB::table('employees')
            ->get();

        $advance_money = DB::table('expenses')
            ->where( 'employee_id', '=', $emp_id)
            ->where( 'salary_month', '=', $month)
            ->where( 'year', '=', $year)
            ->get();

        $advance_salary_amount = DB::table('expenses')
            ->where( 'employee_id', '=', $emp_id)
            ->where( 'salary_month', '=', $month)
            ->where( 'year', '=', $year)
            ->select(DB::raw('SUM(amount) AS amount'))
            ->first();

        return view('attendance.sheet',['advance_money'=> $advance_money,'advance_salary_amount'=>$advance_salary_amount->amount,'this_month_salary'=>$this_month_salary,'days'=>$days,'emp'=>$emp,'employees'=>$employees,'attendances'=> (object) $data,'month'=>$month,'year'=>$year]);


    }



}


