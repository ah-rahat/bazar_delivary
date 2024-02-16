@extends('layouts.app')

@section('content')
    <div class="container login-page">
        <div class="row justify-content-center ">
            <div class="login-form  ">
                <div>
                    <div>
                        <a href="https://gopalganjbazar.com" target="_blank" class="text-center">
                            <img  src="{{ asset('public/images/') }}/grasshopper-logo.png" class="img-responsive logo-login"  />
                        </a>
{{--                        @if(app('request')->input('token') && app('request')->input('sms_method') && app('request')->input('email') )--}}
{{--                            <form method="POST" action="{{ route('authenticate') }}"  >--}}
{{--                                @csrf--}}
{{--                                <div class="form-group row">--}}
{{--                                    <label for="email" class="col-md-12 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <input  type="hidden"   name="token_html" value="{{ app('request')->input('token') }}">--}}
{{--                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ app('request')->input('email') }}" required >--}}

{{--                                        @if ($errors->has('email'))--}}
{{--                                            <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $errors->first('email') }}</strong>--}}
{{--                                    </span>--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group row">--}}
{{--                                    <label for="email" class="col-md-12 col-form-label text-md-right">{{ __('E-Mail OTP Code') }}</label>--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <input  type="hidden"   name="token_html" value="{{ app('request')->input('token') }}">--}}
{{--                                        <input type="text" class="form-control" name="otp_code"   required autofocus>--}}
{{--                                        @if ($errors->has('email'))--}}
{{--                                            <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $errors->first('email') }}</strong>--}}
{{--                                    </span>--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="form-group row mb-0">--}}
{{--                                    <label for="password" class="col-md-12 col-form-label text-md-right">{{ __('Password') }}</label>--}}

{{--                                    <div class="col-md-12">--}}
{{--                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>--}}

{{--                                        @if ($errors->has('password'))--}}
{{--                                            <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $errors->first('password') }}</strong>--}}
{{--                                    </span>--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                @if (Route::has('password.request'))--}}
{{--                                    <a class="pull-right fgttext" href="{{ route('password.request') }}">--}}
{{--                                        {{ __('Forgot Your Password?') }}--}}
{{--                                    </a>--}}
{{--                                @endif--}}
{{--                                <div class="form-group row mb-0">--}}

{{--                                    <div class="col-md-12">--}}
{{--                                        <button type="submit" class="btn btn-primary btn-block">--}}
{{--                                            {{ __('Login') }}--}}
{{--                                        </button>--}}

{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </form>--}}
{{--                        @else--}}
{{--                            @if (session('status'))--}}
{{--                                <div class="alert alert-danger" role="alert">--}}
{{--                                    {{ session('status') }}--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                            <form method="GET" action="{{ route('notify_token_send') }}">--}}
{{--                                @csrf--}}
{{--                                <div class="form-group row">--}}
{{--                                    <label for="email" class="col-md-12 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>--}}
{{--                                        @if ($errors->has('email'))--}}
{{--                                            <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $errors->first('email') }}</strong>--}}
{{--                                    </span>--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group row mb-0">--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <button type="submit" name="email_otp" style="margin-top: 0 !important;" class="btn btn-primary btn-block">--}}
{{--                                            {{ __('SEND EMAIL OTP') }}--}}
{{--                                        </button>--}}
{{--                                        --}}{{--                                <button type="submit" name="sms_otp" class="btn btn-primary btn-block">--}}
{{--                                        --}}{{--                                    {{ __('SEND SMS OTP') }}--}}
{{--                                        --}}{{--                                </button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </form>--}}
{{--                        @endif--}}
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-12 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
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

                            @if (Route::has('password.request'))
                                <a class="pull-right fgttext" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                            <div class="form-group row mb-0">

                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        {{ __('Login') }}
                                    </button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
