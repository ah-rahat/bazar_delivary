@extends('layouts.app')
@section('content')

        @include('layouts.shop-sidebar')

    <div class="content-area">
        <div class="container-fluid mt30">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="panel panel-default simple-panel">
                        <div class="panel-heading">Shop Expense</div>
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif


                                {!! Form::open(['url' => 'shop/shop/save-shop-expense','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}


                            {{ csrf_field() }}
                            <input type="hidden" class="form-control" name="shop_id" value="1" required=""/>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Amount</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="amount" min="0" required=""/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Purpose</label>
                                <div class="col-md-6">
                                     <textarea class="form-control" rows="2" name="purpose"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10"> Date</label>
                                <div class="col-md-6">
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="text" class="form-control" name="date" required=""/>
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <label class="col-md-4 col-form-label text-md-right"> </label>
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>
                <div class="col-md-12">

                    <div class="panel panel-default simple-panel">
                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-responsive inline-tbl" id="example">
                                <thead>
                                <tr>
                                    <th>
                                        SN
                                    </th>
                                    <th>
                                        Amount
                                    </th>
                                    <th>
                                        Purpose
                                    </th>
                                    <th>
                                        Date
                                    </th>
                                    <th>
                                        Added By
                                    </th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($shop_expenses as $index => $shop_expense)
                                    <tr>
                                        <td>
                                            {{$index+1}}
                                        </td>
                                        <td>
                                            &#2547; {{$shop_expense->amount}}
                                        </td>
                                        <td>
                                            {{$shop_expense->purpose}}
                                        </td>
                                        <td>
                                            {{date('d M y', strtotime($shop_expense->date))}}
                                        </td>
                                        <td>
                                            {{$shop_expense->name}}
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
@endsection
@section('footerjs')
    <script>

    </script>
@endsection