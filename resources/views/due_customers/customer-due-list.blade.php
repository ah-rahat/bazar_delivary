
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
                        <div class="panel-heading">Add Due / Receive payment </div>
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif


                                @if(Auth::user()->role === 'admin')
                                    {!! Form::open(['url' => 'ad/save_new_due','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}

                                @elseif(Auth::user()->role === 'manager')
                                    {!! Form::open(['url' => 'pm/save_new_due','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}

                                @endif



                            {{ csrf_field() }}
                                <input type="hidden" class="form-control" id="customer_id" value="{{ $due_customer->id}} "  />
                                <input type="hidden" class="form-control" id="user_id" value="{{ Auth::user()->id}} "  />

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">  Customer Name </label>
                                <div class="col-md-6">

                                    <input type="text"   class="form-control" value="{{$due_customer->name}} " readonly />

                                </div>
                            </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-right mt10">  Customer Phone </label>
                                    <div class="col-md-6">
                                        <input type="text"   class="form-control" value="{{$due_customer->phone}} " readonly />

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-right mt10"> Select Payment Type </label>
                                    <div class="col-md-6">
                                         <select class="form-control" v-model="type" required>
                                             <option value="" selected>Select Option</option>
                                             <option value="add-due">Add New Sales Due</option>
                                             <option value="receive-payment">Receive Due Payment</option>
                                         </select>
                                    </div>
                                </div>
                            <div class="form-group row" v-if="type == 'add-due'">
                                <label for="phone" class="col-md-4 col-form-label text-right mt10">Order ID</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" v-model="order_id" @change="searchOrderAmount()" name="order_id" required="" />
                                </div>
                            </div>
                                <div class="form-group row">
                                    <label for="phone" class="col-md-4 col-form-label text-right mt10">Amount</label>
                                    <div class="col-md-6">
                                        <input type="number" step="any" v-model="order_amount" class="form-control" name="amount" required="" />
                                    </div>
                                </div>

                        </div>


                        <div class="form-group row mb-0">
                            <label   class="col-md-4 col-form-label text-md-right"> </label>
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" @click="savePayment()" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-default simple-panel">
                                <div class="panel-heading">Due : <b>{{$total_dues}}</b> <span style="float: right; color: #e61459;">Remain Due: {{$total_dues - $total_paid}} <b></b></span></div>
                                <div class="panel-body">

                                    <table class="table table-striped table-bordered table-responsive inline-tbl" id="example">
                                        <thead>
                                        <tr>
                                            <th>
                                                Oeder ID
                                            </th>
                                            <th>
                                                Amount
                                            </th>
                                            <th>
Date
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($dues as $due)

                                        <tr>
                                            <td>
                                                {{$due->order_id}}
                                            </td>
                                            <td>
                                                {{$due->amount}}
                                            </td>
                                            <td>
                                                {{$due->order_date}}
                                            </td>

                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-default simple-panel">
                                <div class="panel-heading">Paid:  <b>{{$total_paid}}</b> </div>
                                <div class="panel-body">

                                    <table class="table table-striped table-bordered table-responsive inline-tbl" id="example">
                                        <thead>
                                        <tr>

                                            <th>
                                               Pay Amount
                                            </th>
                                            <th>
                                                Date
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($payments as $payment)

                                            <tr>
                                                <td>
                                                    {{$payment->pay_amount}}
                                                </td>
                                                <td>
                                                    {{$payment->created_at}}
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
    </div>
    </div>

@endsection
@section('footerjs')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js">
    </script>
    <script type="text/javascript">

        var app = new Vue({
            el: '#app',
            delimiters: ['!{', '}!'],
            data: {
                type: null ,
                order_amount: null ,
                order_id: null ,
                order_date: null ,
            },
            created: function () {
                //this.loadApiData();
            },
          methods: {
                savePayment() {
                    var vm = this;
                    if(vm.type == 'add-due'){
                        var vm = this;

                        axios.post('https://gopalganjbazar.com/web/api/save_due_payment',
                            {
                              order_id: vm.order_id,
                              customer_id:  $("#customer_id").val(),
                              user_id:  $("#user_id").val() ,
                              amount: vm.order_amount,
                              order_date: vm.order_date
                            })
                            .then(function (response) {
                                console.log(response.data);
                                if(response.data.message == true){
                                  Command: toastr["info"]("Added Successfully.");
                                  setTimeout(function(){location.reload();},7000);
                                }else{
                                  Command: toastr["error"]("Something Wrong.");
                                }
                            })
                            .catch(function (error) {
                                // handle error
                                console.log(error);
                            });
                    }else{
                      var vm = this;
                      axios.post('https://gopalganjbazar.com/web/api/receive_due_payment',
                        {
                          customer_id:  $("#customer_id").val(),
                          user_id:  $("#user_id").val() ,
                          amount: vm.order_amount,
                        })
                        .then(function (response) {
                          console.log(response.data);
                          if(response.data.message == true){
                            Command: toastr["info"]("Added Successfully.");
                            setTimeout(function(){location.reload();},7000);
                          }else{
                            Command: toastr["error"]("Something Wrong.");
                          }
                        })
                        .catch(function (error) {
                          // handle error
                          console.log(error);
                        });
                    }
                },
                searchOrderAmount() {
                    var vm = this;
                    axios.get('https://gopalganjbazar.com/web/api/admin_single_order/'+vm.order_id)
                        .then(function (response) {
                            // handle success
                            vm.order_amount = response.data.get_single_order.order_total + response.data.get_single_order.delivery_charge - response.data.get_single_order.coupon_discount_amount;
                            vm.order_date = response.data.get_single_order.created_at;
                            vm.order_id = vm.order_id;
                            console.log(vm.order_date);
                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        });

                }
        }
        });
    </script>
@endsection