<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="cHOB9yjUHxOpcQC9bcdk1fDZbo6FeIrmCsHu1X3H">
    <title>
        Water Invoice Summary
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
            font-family: revert;
            color: #000;
            text-shadow: none;
            opacity: 1;
            font-size: 11px;
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
            <div class="container-fluid">
                <div class="justify-content-center">
                    <div class="toparea">
                        <div class="text-center"  style="margin-bottom: 10px;">
                            <h3 style="margin: auto;
font-family: Rajon Shoily;
padding: 0px;
width: fit-content;
font-size: 23px;
color: #000;
font-weight: 500;
line-height: 19px;
opacity: 1;">গোপালগঞ্জ বাজার.কম <br>
                                <small style="    font-size: 16px;color: #000;">বাজার  করুন ঘরে বসে </small>
                                <br>

                            </h3>
                        </div>
                        <div class="productsarea">
                            <table class="table">
                                <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td colspan="3" style="border-bottom: 1px solid #cecece !important;padding: 4px 0 !important;">
                                            {{$order->area}} -   {{$order->name}} -  {{$order->phone}}   - {{$order->address}}
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
    </main>
</div>

<style type="text/css" media="print">

    @page
    {
        size: auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
    }
    #app{
        max-width: inherit !important;
        margin: 0;
    }
    .printMe{
        visibility: hidden;
    }
    .toparea{
        margin-top: -30px;
    }
    .productsarea{
        margin-top: 30px;
    }

    .container-fluid{
        padding: 0 !important;
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
        font-size: 12px;
    }

</style>
<style>
    #app{
        max-width: 320px;
        margin: auto;
    }


    .table > thead > tr > th {
        vertical-align: top;
        border-bottom: 1px solid #ddd;
        padding: 2px 0 !important;
        font-weight: 500;
    }
    .table > tbody > tr > td {
        vertical-align: top !important;
        padding: 2px 0 !important;
    }

    table,tr,td {
        padding: 0;
    }
    table td{
        border: none !important;
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
<style>

</style>
</html>