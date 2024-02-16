
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>	Gopalganj Bazar | Online Shop in Gopalganj City</title>
 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

   <script src="https://use.fontawesome.com/b95bd32606.js"></script>
    <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.min.css" />
     <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <script src="https://use.fontawesome.com/f2988b3c12.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.3/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
</head>
<body>
<div id="app">
    <main>
            @yield('content')
             
        <div id="right-sidebar">
            <div class="sidebar-fixed">
                    @auth
            @if(Auth::user()->role== 'manager' || Auth::user()->role== 'admin')
              <div class="activity">
							<h3>
								Order Activity
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
               url:'/order-activity',
               dataType: "json",
               data:'_token = <?php echo csrf_token() ?>',
               success:function(data) {
                     jQuery('#activity').append(data.success);
                 
               }
            });
            }
           recentorder(); 
         
        
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


<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>

<script>


    $(document).ready(function() {
       // $('.summernote').summernote();
    });
</script>
<script>
    $(function(){

        var current = window.location;

        $('.sidebar li a').each(function(){
            var $this = $(this);
            // if the current path is like this link, make it active
            if($this.attr('href')== current){
                $this.addClass('active');
                $(this).parent().parent().addClass('in');
                $(this).parent().parent().parent().addClass('top');
            }
        });

    // $(".nav-link.active").closest('collapse').addClass('in');
        //$(".nav-link.active").parents('collapse').addClass('in');
    });
    $(document).ready(function() {
            $.noConflict();
        //$('select').select2();
        $('#example').dataTable();
        ///$('#datatable-keytable').DataTable( { keys: true } );
       // $('#datatable-responsive').DataTable(); 
       
    } );
    
     
</script>
<script>
$( document ).ready(function() {
  $('.datepicker').datepicker();
});
 


</script>

</body>
</html>