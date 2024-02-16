<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
     

    <title>	 Bazar Delivery | Online Shop</title>

    <!-- Scripts -->
   <!--
    @if(collect(request()->segments())->last()!='ad')
    <script src="{{ asset('js/app.js') }}" defer></script> 
    @endif
   -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

{{--   <script src="https://use.fontawesome.com/b95bd32606.js"></script>--}}
    <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.1/css/font-awesome.css" />
     <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
      <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    
{{--    <script src="https://use.fontawesome.com/f2988b3c12.js">--}}
{{--    </script>--}}
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.3/Chart.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
</head>
<body>

<div id="app">
<div class="header-top">
<button type="button" class="navbar-toggle" id="colapsebtn">
    <i class="fa fa-th"></i>
  </button>
   
</div>
    <main>
            @yield('content')
             
        <div id="right-sidebar">
            <div class="sidebar-fixed"> 
              @auth
            @if(Auth::user()->role == 'manager' || Auth::user()->role == 'admin' || Auth::user()->role == 'author' || Auth::user()->role == 'shop')
              <div class="activity">
							<h3 class="tagtitle">
							<i class="fa fa-product-hunt pull-left" aria-hidden="true"></i>	Order Activity
							</h3>
							<div id="activity">
							</div>
							<!-- <div class="each-activity create">
							<a href=""> 
							<span><i>#123</i> A New Order has  been created
							</span> <br />
							<i class="fa fa-clock-o"></i> 10.52am 
							</a>
							</div>
							-->
			 </div>
{{--              <div class="min_stock table-responsive">--}}
{{--              <table class="table table-striped table-bordered">--}}
{{--               <thead>--}}
{{--               <tr>--}}
{{--               <th colspan="2" class="text-center close_title">Log Stock Products  <i class="fa fa-close pull-right" style="margin-top: 2px;"></i></th>--}}
{{--               </tr>--}}
{{--               </thead>--}}
{{--               <tbody id="low_stock">--}}
{{--                 --}}
{{--               </tbody>--}}
{{--              </table>--}}
{{--              </div>--}}
              @endif
             @endauth
            </div>
        </div>
    </main>


</div>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
   	<script>
			          
          $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
              });
              
         function recentorder(){  
         $.ajax({
                type:'GET',
             @auth
                @if(Auth::user()->role === 'shop')
                url:'/web/shop-order-activity',
               @else
               url: '{{ URL::to('/') }}/order-activity',
               @endif
               @endauth
               dataType: "json",
               data:'_token = <?php echo csrf_token() ?>',
               success:function(data) {
                //console.log(data);
                     jQuery('#activity').append(data.success);
                     
               }
            });
            }
           recentorder(); 
         
         function logStock(){  
         $.ajax({
               type:'GET',
               url:'/web/low-stock',
               dataType: "json",
               data:'_token = <?php echo csrf_token() ?>',
               success:function(data) {
                //console.log(data);
                    // jQuery('#low_stock').append(data.success);
                 
               }
            });
            }
           logStock(); 
           
		</script>
<!-- 
<script src="{{ asset('public/js/jquery.min.js') }}"></script>-->
 
 
 
  
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.3/Chart.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
 
<!-- include summernote css/js-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
 
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>


<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>

 
<script>

 jQuery('body').on('click', '#colapsebtn', function (e) { 
    jQuery(".left-area").toggleClass("onofme");
});
    jQuery(function(){

        var current = window.location;

        jQuery('.sidebar li a').each(function(){
            var $this = $(this);
            // if the current path is like this link, make it active
            if($this.attr('href')== current){
                $this.addClass('active');
                jQuery(this).parent().parent().addClass('in');
                jQuery(this).parent().parent().parent().addClass('top');
            }
        });

    // $(".nav-link.active").closest('collapse').addClass('in');
        //$(".nav-link.active").parents('collapse').addClass('in');
    });
    jQuery(document).ready(function() {
            jQuery.noConflict();
             jQuery('.summernote').summernote();
        //$('select').select2();
        jQuery('#example').dataTable(
        {
                "order": []
        }
        );
        
        ///$('#datatable-keytable').DataTable( { keys: true } );
       // $('#datatable-responsive').DataTable(); 
       
    } );
           
 toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}   
     
</script>
<script>
jQuery( document ).ready(function() {
  jQuery('.datepicker').datepicker();
  
 
 
});
jQuery(function () {
  jQuery('[data-toggle="popover"]').popover();
  jQuery('.min_stock').hide();  
  
})
 jQuery('body').on('click', '.tagtitle', function (e) {  
    jQuery(".min_stock").show();
});
 jQuery('body').on('click', '.close_title', function (e) {  
    jQuery(".min_stock").hide();
});


</script>
 @yield('footerjs')
 
</body>
</html>

