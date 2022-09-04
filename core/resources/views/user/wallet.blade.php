@extends('layouts.user-frontend.user-dashboard')

@section('style')
    <style>
        input[type="text"] {
            width: 100%;
        }
    </style>
@endsection
@section('content')
    @include('layouts.breadcam')

    <div class="content_padding">
        <div class="container user-dashboard-body">

            <div class="row">
                <div class="login-admin login-admin1">
                    <div class="login-header text-center">
                        <h6>{!! $page_title  !!}</h6>
                    </div>
                    {!! Form::open(['method'=>'post','role'=>'form','class'=>'form-horizontal','files'=>true]) !!}
                    <div class="row">
                        <div class="col-md-9 col-md-offset-3">
                            <div class="row">

                                @if($user_datas)

                                    @foreach($user_datas as $user_data)

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;"> Ví Tiền : {{ $user_data->miner->code }}</strong></label>
                                                <div class="col-md-12">
                                                    <input type="text" name="{{ $user_data->category_id }}" id="" value="{{ $user_data->wallet }}" placeholder="{{ $user_data->miner->name }} Wallet">
                                                </div>
                                            </div>
                                        </div>

                                @endforeach

                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                                <button type="submit" class="new-btn-submit">CẬP NHẬT VÍ</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/admin/js/bootstrap-fileinput.js') }}"></script>

    @if (session('message'))

        <script type="text/javascript">

            $(document).ready(function(){

                swal("Success!", "{{ session('message') }}", "success");

            });

        </script>

    @endif

    @if (session('alert'))

        <script type="text/javascript">

            $(document).ready(function(){

                swal("Sorry!", "{!! session('alert') !!}", "error");

            });

        </script>

    @endif
@endsection
