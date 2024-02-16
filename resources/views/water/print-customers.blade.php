<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="cHOB9yjUHxOpcQC9bcdk1fDZbo6FeIrmCsHu1X3H">
    <title>
        Print Order
    </title>
    <!-- Scripts -->
    <script src="http://mmmethod.net/shop/js/app.js" defer>
    </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=Quicksand:wght@500;515&family=Raleway:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/b95bd32606.js">
    </script>

    <link href="http://mmmethod.net/shop/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Gruppo&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Codystar&family=Raleway+Dots&family=Snippet&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Life+Savers&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Snippet&display=swap" rel="stylesheet">
    <!--     font-family: 'Snippet', sans-serif; font-family: 'Snippet', sans-serif;-->
    <style>
        body,table,tr,td,p,span,div{
            font-family: 'Gruppo', cursive;
            color: #000;
            text-shadow: none;
            opacity: 1;
        }
    </style>
    <script src="https://use.fontawesome.com/f2988b3c12.js">


    </script>
</head>
<body style="background: #fff;">
<span     class="btn btn-block btn-sm btn-info printMe" style="border-radius: 0px;background: #e05544;border: 1px solid #de3c31;padding: 5px 0;font-size: 16px;"><i class="fa fa-print" aria-hidden="true"></i> PRINT INVOICE</span>
<div id="app">
    <main>
        <div>
            <div class="container-fluid mt30">
                <div class="justify-content-center">

                    <div class="area" style="padding-right: 12px;">
                        <div  style="margin-bottom: 50px;">
                            <img src="http://mmmethod.net/shop/images/favo.jpg" alt="invoice icon" style="width: 41px; float: left;" />

                            <span style="font-size: 20px;margin-top: 6px;float: left;margin-left: 15px;">
										Customers
									</span>
                        </div>
                        <div style="text-align: right;float: right; width: 48%;">
                            <p style="font-size: 12px;margin: 0 0 5px;" class="color">
                                GOPALGANJ BAZAR
                            </p>
                            <p style="margin: 0 0 5px;">
                                Gopalganj City
                            </p>
                            <p style="margin: 0 0 5px;;">
                                Phone:  01931-313141
                            </p>
                            <p style="margin: 0 0 5px;">
                                Office Copy
                            </p>

                            <br />
                        </div>
                        <div class="productsarea">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>
                                        S/N
                                    </th>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                         NAME
                                    </th>
                                    <th class="text-center">
                                       PHONE
                                    </th>
                                    <th class="text-center">
                                        AREA
                                    </th>
                                    <th class="text-center">
                                        ADDRESS
                                    </th>
                                    <th class="color text-center"  >
                                        Given Jar
                                    </th>
                                    <th class="color text-center">
                                        Taken Jar
                                    </th>
                                    <th  class="color text-center">
                                        Payment
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($customers as $index => $customer)
                                    <tr>
                                       <td style="font-weight: bold;">{{ $index+1 }}</td>
                                       <td>#{{$customer->id}}</td>
                                       <td>{{$customer->name}}</td>
                                       <td>{{$customer->phone}}</td>
                                       <td>
                                           @foreach($areas as $area)
                                               @if($area->id==$customer->area_id)

                                                   <small>{{$area->location_name_bn}}</small>)
                                               @endif
                                           @endforeach
                                       </td>
                                       <td>{{$customer->address}}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
</div>

<style type="text/css" media="print">

    @page
    {
        size: auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
    }
    .printMe{
        visibility: hidden;
    }
    .area{
        margin-top: -40px;
    }
    .productsarea{
        margin-top: 30px;
    }
    p.inv_id{
        word-break: keep-words !important;
        color: red;
        width: 150px;
    }
    .color{
        font-weight: 400 !important;
    }

    .table > thead > tr > th {
        font-size: 11.5px;
    }

</style>
<style>

    .table > thead > tr > th {
        vertical-align: bottom;
        border-bottom: 1px solid #ddd;
        padding: 2px 0 !important;
        font-family: arial;
        font-weight: 500;
    }
    .table > tbody > tr > td {
        padding: 2px 0 !important;
    }
    .area{
        width: 100%;
        float: left;
        display: inline-table;
        font-size: 12px;
    }
    table,tr,td {
        padding: 0;
    }
    .table > tbody > tr > td {
        padding: 5px !important;
        padding-top: 4px;
        padding-right: 0px;
        font-family: arial;
        padding-bottom: 4px;
        padding-left: 0px;
        border: 1px solid #33333354  !important;
    }

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js">
</script>
<!-- <script src="https://web.gopalganjbazar.com/public/js/jquery.min.js"></script>-->
<!-- include summernote css/js-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
</script>
<script>
    $('.printMe').click(function() {
        window.print();
        return false;
    });

</script>
</body>

</html>