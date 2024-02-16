@extends('layouts.app')
@section('content')

        @include('layouts.shop-sidebar')

    <div class="content-area">
        <div class="container-fluid mt30">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="panel panel-default simple-panel">
                        <div class="panel-heading">Shop Stock Money Manage</div>
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif


                                {!! Form::open(['url' => 'shop/save-shop-money','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}


                            {{ csrf_field() }}
                            <input type="hidden" class="form-control" name="shop_id" value="1" required=""/>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Amount</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="amount" min="0" required=""/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Type</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="type">
{{--                                        <option value="">Select Type</option>--}}
                                        <option value="money-plus" selected>Give Stock Money</option>
{{--                                        <option value="money-minus">Minus From Stock Money</option>--}}
                                    </select>
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
                                        Type
                                    </th>

                                    <th>
                                        G/T Date
                                    </th>
                                    <th>
                                        Create Date
                                    </th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($shop_investments as $index => $investment)
                                    <tr>
                                        <td>
                                            {{$index+1}}
                                        </td>
                                        <td>
                                            &#2547; {{$investment->amount}}
                                        </td>
                                        <td>
                                            {{$investment->type}}
                                        </td>
                                        <td>
                                            {{date('d M y', strtotime($investment->date))}}
                                        </td>
                                        <td>
                                            {{date('d M y', strtotime($investment->created_at))}}
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