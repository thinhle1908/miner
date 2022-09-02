@extends('layouts.newfrontend')

@section('style')
    <style>
        .btn-facebook {
            color: #ffffff !important;
            text-decoration: none !important;
            text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
            background-color: #2b4b90;
            *background-color: #133783;
            background-image: -moz-linear-gradient(top, #3b5998, #133783);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#3b5998), to(#133783));
            background-image: -webkit-linear-gradient(top, #3b5998, #133783);
            background-image: -o-linear-gradient(top, #3b5998, #133783);
            background-image: linear-gradient(to bottom, #3b5998, #133783);
            background-repeat: repeat-x;
            border-color: #133783 #133783 #091b40;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff3b5998', endColorstr='#ff133783', GradientType=0);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
        }

        .btn-facebook:hover,
        .btn-facebook:focus,
        .btn-facebook:active,
        .btn-facebook.active,
        .btn-facebook.disabled,
        .btn-facebook[disabled] {
            color: #ffffff !important;
            background-color: #133783;
            *background-color: #102e6d;
        }

        .btn-facebook:active,
        .btn-facebook.active {
            background-color: #0d2456 \9;
        }
        .btn-google-plus {
            color: #ffffff !important;
            text-decoration: none !important;
            text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
            background-color: #d34332;
            *background-color: #c53727;
            background-image: -moz-linear-gradient(top, #dd4b39, #c53727);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#dd4b39), to(#c53727));
            background-image: -webkit-linear-gradient(top, #dd4b39, #c53727);
            background-image: -o-linear-gradient(top, #dd4b39, #c53727);
            background-image: linear-gradient(to bottom, #dd4b39, #c53727);
            background-repeat: repeat-x;
            border-color: #c53727 #c53727 #85251a;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffdd4b39', endColorstr='#ffc53727', GradientType=0);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
        }

        .btn-google-plus:hover,
        .btn-google-plus:focus,
        .btn-google-plus:active,
        .btn-google-plus.active,
        .btn-google-plus.disabled,
        .btn-google-plus[disabled] {
            color: #ffffff !important;
            background-color: #c53727;
            *background-color: #b03123;
        }

        .btn-google-plus:active,
        .btn-google-plus.active {
            background-color: #9a2b1f \9;
        }
    </style>
@endsection

@section('content')

    <!--header section start-->
    <section class="breadcrumb-section" style="background-image: url('{{ asset('assets/images') }}/{{ $basic->breadcrumb }}')">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <!-- breadcrumb Section Start -->
            <div class="breadcrumb-content">
               <h5>{{ $page_title}}</h5>
            </div>
            <!-- Breadcrumb section End -->
          </div>
        </div>
      </div>
    </section>
    <!--Header section end-->


    <!--login section start-->
<section  class="circle-section section-padding section-background">
    <div class="container">
        <div class="row">
  
            <div class="col-md-6 col-md-offset-3">
                <div class="login-admin login-admin1">
                    <div class="login-header text-center">
                      <h6>Login Form</h6>
                    </div>
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    {!!  $error !!}
                                </div>
                            @endforeach
                        @endif
                        
                        @if (session()->has('message'))
                            <div class="alert alert-{{ session()->get('type') }} alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        
                        @if (session()->has('status'))
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{ session()->get('status') }}
                            </div>
                        @endif
                       <div class="login-form"> 
                        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <input type="text" name="username" id="username" required placeholder="Enter your User Name"/>     
                            <input type="password" name="password" id="password" required placeholder="Enter your Password"/>

                           <input value="Login" type="submit">

                           @if($basic->fb_login == '1' || $basic->g_login == '1')

                            <div class="form-group">
                                @if($basic->fb_login == '1')
                                <div class="col-sm-6">
                                    <a href="{{ url('login/facebook') }}" class="btn btn-facebook btn-block">
                                        <i class="fa fa-facebook"></i> | Connect with Facebook
                                    </a>
                                </div>
                                @endif
                                @if($basic->g_login == '1')
                                <div class="col-sm-6">
                                    <a href="{{ url('login/google') }}" class="btn btn-google-plus btn-block">
                                        <i class="fa fa-google-plus"></i> | Connect with Google
                                    </a>
                                </div>
                                @endif
                            </div>

                            @endif

                             <div class="form-group">
                                <div class="cols-sm-10 cols-sm-offset-2">
                                    <div class="col-sm-12 text-center">
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            Forgot Your Password?
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</section>

@endsection
