<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>  Bazar Delivery | Online Shop in Gopalganj City</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
            
                <div class="top-right links">
                    @auth
                        @if(Auth::user()->role === 'admin')
                        <a href="{{ url('ad/') }}/">
                           Dashboard
                        </a>
                            @elseif(Auth::user()->role === 'vendor')
                            <a href="{{ url('ve/') }}/">
                              Vendor  Dashboard
                            </a>
                        @elseif(Auth::user()->role === 'author')
                            <a href="{{ url('au/today-orders') }}/">
                                Today Orders
                            </a>
                             @elseif(Auth::user()->role === 'manager')
                            <a href="{{ url('pm/') }}/">
                                Manager Dashboard
                            </a>
                        @elseif(Auth::user()->role === 'shop')
                            <a href="{{ url('shop/') }}/">
                                Shop Dashboard
                            </a>
                            @else
                        @endif
                        <a    href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
{{--                        <a href="{{ route('login') }}">Login</a>--}}
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            {{--<a href="{{ route('register') }}">Register</a>--}}
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md" style="padding: 0 15px;">
                     <img src="{{ asset('public/images/') }}/grasshopper-logo.png" class="img-responsive" style="max-width: 450px; width: 100%;" />
                </div>


            </div>
        </div>
    </body>
</html>
