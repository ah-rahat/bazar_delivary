
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="sl0BkIGv0Qqqxe8V8bcEinbiaPHuc1zOlB2xqNVg">

    <title>	Gopalganj Bazar | Online Shop in Gopalganj City</title>

    <!-- Scripts -->
    <script src="https://web.gopalganjbazar.com/js/app.js" defer></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

   <script src="https://use.fontawesome.com/b95bd32606.js"></script>
    <!-- Styles -->
     <link href="https://web.gopalganjbazar.com/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://web.gopalganjbazar.com/css/style.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/f2988b3c12.js">
    </script>
</head>
<body>
<div id="app">
    <main>
            <div class="container login-page">
    <div class="row justify-content-center ">
        <div class="login-form  ">
            <div>
                <div>
                    <a href="https://gopalganjbazar.com/" target="_blank" class="text-center">
                    <img  src="https://web.gopalganjbazar.com/public//images/grasshopper-logo.png" class="img-responsive logo-login"  />
                    </a>
                                               @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                                           <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-12 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-12 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-12 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-12">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
             
        <div id="right-sidebar">
            <div class="sidebar-fixed">
                                </div>
        </div>
    </main>


</div>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
   	   
<!-- include summernote css/js--> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
 

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

</body>
</html>
 