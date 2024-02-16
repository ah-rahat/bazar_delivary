<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\expense;
use App\asset;
use App\other_income;

use App\expense_category;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Yuansir\Toastr\Facades\Toastr;


class ExpenseController extends Controller
{

    public function asset_index()
    {
        $assets = DB::table('assets')
            ->join('users', 'users.id', '=', 'assets.user_id')
            ->orderBy('assets.id', 'DESC')
            ->select('assets.*', 'users.name as  name')
            ->get();
        $asset_amount = DB::table('assets')
            ->select(DB::raw('sum(assets.amount) as amount'))
            ->first();

        return view('assets.new-asset', ['assets' => $assets, 'asset_amount' => $asset_amount]);
    }

    public function save_asset(Request $request)
    {
        $userId = Auth::id();
        $asset = new asset();
        $asset->purpose = $request->purpose;
        $asset->type = $request->type;
        $asset->quantity = $request->quantity;
        $asset->amount = $request->amount;
        $asset->date = date("Y-m-d", strtotime($request->date));
        $asset->user_id = $userId;
        $asset->created_at = now();
        $asset->updated_at = now();
        $asset->save();
        $request->session()->flash('status', ' New Asset  added successfully!');
        return redirect()->back();

    }


    public function show_form()
    {
        return view('income.create');
    }

    public function income_list()
    {

        $income_amount = DB::table('other_incomes')
            ->select(DB::raw('sum(other_incomes.amount) as amount'))
            ->first();


        $data = DB::table('other_incomes')
            ->orderBy('id', 'DESC')
            ->get();

        return view('income.index', ['incomes' => $data, 'income_amount' => $income_amount]);
    }


    public function save_income(Request $request)
    {
        $user_id = Auth::user()->id;
        $date = date("yy-m-d", strtotime($request->date));
        $income = new other_income();
        $income->amount = $request->amount;
        $income->date = $date;
        $income->purpose = $request->purpose;
        $income->user_id = $user_id;
        $income->save();
        $request->session()->flash('status', ' Income added successfully!');
        return redirect()->back();


    }


    public function expense_calculate($start_date, $end_date)
    {
        $new_startDate = $start_date;
        $new_endDate = $end_date;


        $total_expense_amount = DB::table('expenses')
            ->whereBetween('date', [$new_startDate, $new_endDate])
            ->select(DB::raw('sum(expenses.amount) as total_expense'))
            ->first();

        return response()->json([
            'total_expense_amount' => $total_expense_amount
        ]);
    }


    public function expense_category()
    {
        $expense_categories = expense_category::all();
        return view('expense.expense-category', ['expense_categories' => $expense_categories]);
    }

    public function save_expense_category(Request $request)
    {


        $expense_category = new expense_category();
        $expense_category->type = $request->type;
        $expense_category->save();
        $request->session()->flash('status', ' New Expense Category added successfully!');
        return redirect()->back();

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
//        if (Auth::user()->role == 'admin') {
            $expenses = DB::table('expenses')
                ->join('users', 'users.id', '=', 'expenses.user_id')
                ->leftjoin('expense_categories', 'expense_categories.id', '=', 'expenses.type')
                ->orderBy('expenses.id', 'DESC')
                ->select('expenses.*', 'expense_categories.type', 'users.name as  name')
                ->get();
//        } elseif (Auth::user()->role == 'manager') {
//            $expenses = DB::table('expenses')
//                ->join('users', 'users.id', '=', 'expenses.user_id')
//                ->leftjoin('expense_categories', 'expense_categories.id', '=', 'expenses.type')
//                ->orderBy('expenses.id', 'DESC')
//                ->where('users.id', '=', $user_id)
//                ->select('expenses.*', 'users.name as  name')
//                ->get();
//        }
        $employees = DB::table('employees')  ->get();
        return view('expense.index', ['expenses' => $expenses,'employees' => $employees]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create_expense()
    {
        $expense_categories = expense_category::where('id', '!=', 13)->get();
        $employees = DB::table('employees')->get();

        return view('expense.manager-new-expense', ['expense_categories' => $expense_categories, 'employees' => $employees]);
    }
    public function create()
    {
        $expense_categories = expense_category::where('id', '!=', 13)->get();
        $employees = DB::table('employees')
            ->where('employees.status', '=', 1)
            ->get();

        return view('expense.new-expense', ['expense_categories' => $expense_categories, 'employees' => $employees]);
    }

    public function affiliate_payment_form()
    {

        $affiliators = DB::table('users')
                ->join('marketers', 'marketers.user_id', '=', 'users.id')
            ->get();

        return view('expense.affiliate-payment', ['affiliators' => $affiliators]);
    }



    public function affiliate_payment_save(Request $request)
    {
        $status = 1;
        $userId = Auth::id();
        $expense = new expense();
        $expense->purpose = $request->purpose;
        $expense->amount = $request->amount;
        $expense->date = date("Y-m-d", strtotime($request->date));
        $expense->type = 13;
        $expense->affiliate_id = $request->affiliate_id;
        $expense->status = $status;
        $expense->user_id = $userId;
        $expense->created_at = now();
        $expense->updated_at = now();
        $expense->save();

        DB::table('stock_money')->insert([
            'amount' => $request->amount,
            'type' => 'money-minus',
            'purpose' => 'Affiliate payment',
            'date' => date("Y-m-d", strtotime($request->date)),
            'user_id' => Auth::id(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $request->session()->flash('status', ' Payment  added successfully!');
        return redirect()->back();

    }

    public function save_expense(Request $request)
    {



        $status = 1;
        $userId = Auth::id();
        $expense = new expense();
        if ($request->type == 14) {
            $expense->employee_id = $request->employee_id;
            $expense->salary_month = $request->month;
            $expense->year = date('Y');
        }
        $expense->purpose = $request->purpose;
        $expense->amount = $request->amount;
        $expense->date = date("Y-m-d", strtotime($request->date));
        $expense->type = $request->type;
        $expense->status = $status;
        $expense->user_id = $userId;
        $expense->created_at = now();
        $expense->updated_at = now();
        $expense->save();
        if($request->source == 1){
            DB::table('stock_money')->insert([
                'amount' => $request->amount,
                'type' => 'money-minus',
                'purpose' => $request->purpose,
                'date' => date("Y-m-d", strtotime($request->date)),
                'user_id' => Auth::id(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        $request->session()->flash('status', ' New Expense  added successfully!');
        return redirect()->back();

    }


//    public function manager_save_expense(Request $request)
//    {
//
//
//        $status = 0;
//
//        $userId = Auth::id();
//        $expense = new expense();
//
//        $expense->purpose = $request->purpose;
//        $expense->amount = $request->amount;
//        $expense->date = date("Y-m-d", strtotime($request->date));
//        $expense->type = $request->type;
//        $expense->status = $status;
//        $expense->user_id = $userId;
//        $expense->created_at = now();
//        $expense->updated_at = now();
//        $expense->save();
////        if($request->source == 1){
////            DB::table('stock_money')->insert([
////                'amount' => $request->amount,
////                'type' => 'money-minus',
////                'purpose' => $request->purpose,
////                'date' => date("Y-m-d", strtotime($request->date)),
////                'user_id' => Auth::id(),
////                'created_at' => Carbon::now(),
////                'updated_at' => Carbon::now()
////            ]);
////        }
//        $request->session()->flash('status', ' New Expense  added successfully!');
//        return redirect()->back();
//
//    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function approve_expense(Request $request)
    {

        $user_id = Auth::user()->id;
        DB::table('expenses')->where('id', $request->id)->update(['status' => 1, 'approved_by' => $user_id]);

        $expense = DB::table('expenses')->where('id', $request->id)->first();

        $date = date('Y-m-d');

        DB::table('stock_money')->insert([
                'amount' => $expense->amount,
                'type' => 'money-minus',
                'purpose' => $expense->purpose,
                'date' => date("Y-m-d", strtotime($date)),
                'user_id' => Auth::id(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);


        $request->session()->flash('status', 'Expense Approved successfully!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\expense $expense
     * @return \Illuminate\Http\Response
     */
    public function show(expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\expense $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\expense $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\expense $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(expense $expense)
    {
        //
    }
}
