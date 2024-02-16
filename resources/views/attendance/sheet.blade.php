@extends('layouts.app')

@section('content')
    @if(Auth::user()->role === 'admin')
        @include('layouts.admin-sidebar')
    @else
        @include('layouts.other-sidebar')
    @endif

    <div class="content-area">
        <div class="container-fluid mt30">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">Entry Attendance For <span
                                    style="font-weight: bold;text-transform: uppercase;">{{$emp->name}}</span> <a
                                    href="
                                         @if(Auth::user()->role === 'admin')
                                    {{ url("/ad/attendance")}}
                                    @elseif(Auth::user()->role === 'manager')
                                    {{ url("/pm/attendance")}}
                                    @endif

                                            ">Back Page</a>
                            <span class="pull-right" style="font-weight: bold;text-transform: uppercase;">Salary AMount:   {{ number_format($this_month_salary,2) }} Month: {{ date("F",mktime(0,0,0,$month))}}</span>
                        </div>
                        <div class="panel-body">
                            <div>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <td class="text-uppercase">Date</td>
                                        <td class="text-uppercase" width="100px"> </td>
                                        <td class="text-uppercase">Status</td>
                                        <td class="text-uppercase">Overtime</td>
                                        <td class="text-uppercase">Late Time</td>
                                        <td class="text-uppercase">Comments</td>
                                        <td class="text-uppercase"></td>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($attendances as $attendance)

                                        <tr id="{{ date('d', strtotime($attendance->date))}}">
                                            <td>  <span class="badge green">{{ date("F",mktime(0,0,0,$month))}}
                                                    {{ explode('-', $attendance->date)['2']}}
                                                   </span></td>
                                            <td>
                                                @if(Auth::user()->role === 'admin')
                                                    <select class="form-control " name="status"  >
                                                        <option value="">Select</option>
                                                        <option value="P">Present</option>
                                                        <option value="A">Absent</option>
                                                        <option value="H">Holiday</option>
                                                    </select>

                                                @endif
                                               @if(!$attendance->status && Auth::user()->role === 'manager')
                                                        <select class="form-control " name="status">
                                                            <option value="">Select</option>
                                                            <option value="P">Present</option>
                                                            <option value="A">Absent</option>
                                                            <option value="H">Holiday</option>
                                                        </select>
                                                    @endif
                                            </td>
                                            <td>
                                                @if($attendance->status)
                                                    @if($attendance->status == "A")
                                                        <span class="absent">Absent</span>
                                                    @elseif($attendance->status == "P")
                                                        <span class="present">Present</span>
                                                    @elseif($attendance->status == "H")
                                                        <span class="holiday">Holiday</span>
                                                    @endif

                                                @endif
                                            </td>
 
                                            <td><input type="number" value="{{$attendance->overtime}}"
                                                       class="form-control w100 overtime"></td>
                                            <td><input type="number" value="{{$attendance->late}}"
                                                       class="form-control w100 late"></td>
                                            <td><textarea
                                                        class="form-control h33 comment">{{$attendance->comment}}</textarea>
                                            </td>
                                            <td>
                                                <button class="btn btn-success btn-sm"
                                                        onclick="update_attendance({{ date('d', strtotime($attendance->date))}},{{$month}},{{$year}},{{$emp->id}})">
                                                    SAVE
                                                </button>

                                            </td>
                                        </tr>

                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-md-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">Advance Salary <span style="float: right;text-transform: uppercase;color: #ca0a25;font-weight: 600;">Remaining Salary: {{ number_format($this_month_salary - $advance_salary_amount,2) }}</span> </div>
                        <div class="panel-body">
                            <div>
                                <table class="table table-striped ">
                                    <thead>
                                    <tr>
                                        <td class="text-uppercase">Date</td>
                                        <td>Amount</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($advance_money as $advance )
                                    <tr>
                                        <td>{{date('d M y', strtotime($advance->date))}}</td>
                                        <td>{{$advance->amount}}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="right-humberger-menu">

                </div>
            </div>
        </div>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <style>
        .present {
            background: #9ce8a1d9;
            padding: 4px 6px;
            border-radius: 3px;
            font-size: 12px;
            text-transform: uppercase;
            color: #4caf50;
            font-weight: 700;
        }

        .absent {
            background: #ffecb3;
            padding: 4px 6px;
            border-radius: 3px;
            font-size: 12px;
            text-transform: uppercase;
            color: #ff8f00;
            font-weight: 700;
        }

        .holiday {
            color: #039be5;
            background: #b3e5fc;
            padding: 4px 6px;
            border-radius: 3px;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 700;
        }

        textarea.form-control.h33 {
            height: 50px !important;
        }

        input.w100 {
            width: 150px !important;
        }

        .badge.green {
            padding: 5px 10px;
            border-radius: 3px;
            color: #594c4c !important;
            background: #fff;
        }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        function update_attendance(day, month, year, emp_id) {


            let length = day.toString().length;

            if (length == 1) {
                var status = $("#0" + day + ' select').val();
                var overtime = $("#0" + day + ' .overtime').val();
                var comment = $("#0" + day + ' .comment').val();
                var late = $("#0" + day + ' .late').val();
            } else {
                var status = $("#" + day + ' select').val();
                var comment = $("#" + day + ' .comment').val();
                var late = $("#" + day + ' .late').val();
                var overtime = $("#" + day + ' .overtime').val();
            }


            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'POST',
                @if(Auth::user()->role === 'admin')
                url: '/web/ad/sheet/update',
                @elseif(Auth::user()->role === 'manager')
                url: '/web/pm/sheet/update',
                @endif

                dataType: "json",
                data: {
                    status: status,
                    comment: comment,
                    overtime: overtime,
                    day: day,
                    late: late,
                    month: month,
                    year: year,
                    emp_id: emp_id,
                    _token: _token
                },
                success: function (data) {
                    console.log(data);
                    Command: toastr["info"]("Attendance Updated Successfully.");
                }
            });

        }

    </script>
@endsection

