
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
                    <div class="panel-heading">Add Investment </div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                  {!! Form::open(['url' => 'ad/save-invest','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}

                         {{ csrf_field() }}
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Select investor</label>
                                <div class="col-md-6">
                                    <select class="form-control"  name="investor" required>
                                        <option value="">Select</option>
                                        <option value="Moin Khan">Moin Khan</option>
                                        <option value="Mazaharul Islam">Mazahar Islam</option>
                                        <option value="Monirul Islam">Monirul Islam</option>
                                        <option value="Safiquel Islam Naiem">Safiquel Islam Naiem</option>
                                        <option value="Tanim Bhuiyan">Tanim Bhuiyan</option>
                                        <option value="Nazrul Islam">Nazrul Islam</option>
                                        <option value="Nazim Ahmed  (Ratna Apu)">Nazim Ahmed  (Ratna Apu)</option>

                                        <option value="Happy">Happy</option>
                                        <option value="Ratna">Ratna</option>
                                        <option value="Sifat">Sifat</option>
                                        <option value="Nowrin Islam Nipa">Nowrin Islam Nipa</option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-right mt10">Invest Amount</label>
                            <div class="col-md-6">
                               <input type="number" class="form-control" name="amount" min="0" required="" />
                            </div>
                        </div>
                         
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Invest Date</label>
                                <div class="col-md-6">
                                      <div class="input-group date" data-provide="datepicker">
                  <input type="text" class="form-control" name="date"  required=""/>
                  <div class="input-group-addon">
                      <span class="glyphicon glyphicon-th"></span>
                  </div>
              </div>
                                </div>
                            </div>

                            </div>

                        <div class="form-group row mb-0">
                            <label   class="col-md-4 col-form-label text-md-right"> </label>
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
                    <div class="panel-heading">
                        Investment List <span class="pull-right text-right" style="font-size: 15px;">Total Invest: <span style="font-weight: 600; color: #ff8f00;font-size: 15px;"> &#2547; {{ number_format($invest->amount, 2) }}</span> </span>
                    </div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <table class="table table-striped table-bordered table-responsive inline-tbl" id="example">
                            <thead>
                            <tr>
                                <th>
                                    SN
                                </th>
                                <th>
                                    Investor
                                </th>
                                <th>
                                    Amount
                                </th>
                                <th>
                                    Date
                                </th>
                                <th>
                                    Create Date
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($investments as $index => $investment)
                                <tr>
                                    <td>
                                        {{$index+1}}
                                    </td>
                                    <td>
                                       {{$investment->investor}}
                                    </td>
                                    <td>
                                        &#2547; {{$investment->amount}}
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
        jQuery(".report_date_range input").val('');

        jQuery('.input-daterange input').each(function() {
            jQuery(this).datepicker({
                clearDates:true,
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                autoclose: true
            });
        });


    </script>
@endsection