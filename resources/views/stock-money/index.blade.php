@extends('layouts.app')
@section('content')
    @if(Auth::user()->role === 'admin')
        @include('layouts.admin-sidebar')
    @else
        @include('layouts.other-sidebar')
    @endif
    <div class="content-area">
        <div class="container-fluid mt30">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="panel panel-default simple-panel">
                        <div class="panel-heading">Stock Money Manage</div>
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if(Auth::user()->role === 'admin')
                                {!! Form::open(['url' => 'ad/save-stock-manage','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}

                            @elseif(Auth::user()->role === 'manager')
                                {!! Form::open(['url' => 'pm/save-stock-manage','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}

                            @endif

                            {{ csrf_field() }}

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
                                            <option value="">Select Type</option>
                                            <option value="money-plus">Plus Stock Money</option>
                                            <option value="money-minus">Minus From Stock Money</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-right mt10">Purpose</label>
                                    <div class="col-md-6">
                                        <textarea class="form-control" name="purpose" rows="1" placeholder="Why and  who  take  Money" required></textarea>
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
                                        Purpose
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
                                @foreach ($stockMonies as $index => $stock)
                                    <tr>
                                        <td>
                                            {{$index+1}}
                                        </td>
                                        <td>
                                            &#2547; {{$stock->amount}}
                                        </td>
                                        <td>
                                            {{$stock->type}}
                                        </td>
                                        <td>
                                            {{$stock->purpose}}
                                        </td>
                                        <td>
                                            {{date('d M y', strtotime($stock->date))}}
                                        </td>
                                        <td>
                                            {{date('d M y', strtotime($stock->created_at))}}
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