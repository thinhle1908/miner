@extends('layouts.dashboard')
@section('style')

    <link href="{{ asset('assets/admin/css/bootstrap-toggle.min.css') }}" rel="stylesheet">


@endsection
@section('content')

    @if(count($user))

        <div class="row">
            <div class="col-md-12">


                <div class="portlet blue box">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <strong>Chi tiết người dùng</strong>
                        </div>
                        <div class="tools"> </div>
                    </div>
                    <div class="portlet-body" style="overflow:hidden;">

                        <div class="col-md-3">
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption uppercase bold">
                                        <i class="fa fa-user"></i> HỒ SƠ </div>
                                </div>
                                <div class="portlet-body text-center" style="overflow:hidden;">
                                    <img src="@if($user->image == 'user-default.png') {{ asset('assets/images/user-default.png') }} @else {{ asset('assets/images') }}/{{ $user->image }}@endif" class="img-responsive propic" alt="Profile Pic">

                                    <hr><h4 class="bold">Tên tài khoản : {{ $user->username}}</h4>
                                    <h4 class="bold">Tên : {{ $user->name }}</h4>
                                    <h4 class="bold">Số dư : {{ $user->balance }} {{ $basic->currency }}</h4>
                                    <hr>
                                    @if($user->login_time != null)
                                        <p>
                                            <strong>Lần đăng nhập cuôi : {{ \Carbon\Carbon::parse($user->login_time)->diffForHumans() }}</strong> <br>
                                        </p>
                                    <hr>
                                    @endif
                                    @if($last_login != null)
                                    <p>
                                        <strong>Lần đăng nhập cuối cùng từ</strong> <br> {{ $last_login->user_ip }} -  {{ $last_login->location }} <br> Sử dụng {{ $last_login->details }} <br>
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="portlet box purple">
                                        <div class="portlet-title">
                                            <div class="caption uppercase bold">
                                                <i class="fa fa-desktop"></i> Thông tin chi tiết </div>
                                            <div class="tools"> </div>
                                        </div>
                                        <div class="portlet-body">

                                            <div class="row">

                                                <a href="{{ route('user-deposit-all',$user->username) }}">
                                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
                                                        <div class="dashboard-stat green">
                                                            <div class="visual">
                                                                <i class="fa fa-cloud-upload"></i>
                                                            </div>
                                                            <div class="details">
                                                                <div class="number">
                                                                    <span data-counter="counterup" data-value="{{ $total_deposit }}">0</span>
                                                                </div>
                                                                <div class="desc uppercase bold "> ĐẶT CỌC </div>
                                                            </div>
                                                            <div class="more">
                                                                <div class="desc uppercase bold text-center">
                                                                    {{ $basic->symbol }}
                                                                    <span data-counter="counterup" data-value="{{ $total_deposit_amount }}">0</span> DEPOSIT
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <!-- END -->

                                                <a href="{{ route('plan.logs.user', $user->id) }}">
                                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
                                                        <div class="dashboard-stat red">
                                                            <div class="visual">
                                                                <i class="fa fa-network"></i>
                                                            </div>
                                                            <div class="details">
                                                                <div class="number">
                                                                    <span data-counter="counterup" data-value="{{ $plan_logs }}">0</span>
                                                                </div>
                                                                <div class="desc uppercase  bold "> Các gói đã mua </div>
                                                            </div>
                                                            <div class="more">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <!-- END -->

                                                <a href="{{ route('user-login-all',$user->username) }}">
                                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 20px;">
                                                        <div class="dashboard-stat yellow">
                                                            <div class="visual">
                                                                <i class="fa fa-sign-in"></i>
                                                            </div>
                                                            <div class="details">
                                                                <div class="number">
                                                                    <span data-counter="counterup" data-value="{{ $total_login }}">0</span>
                                                                </div>
                                                                <div class="desc uppercase  bold "> Đăng nhập</div>
                                                            </div>
                                                            <div class="more">
                                                                <div class="desc uppercase bold text-center">
                                                                    XEM CHI TIẾT
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <!-- END -->

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="portlet box blue-ebonyclay">
                                        <div class="portlet-title">
                                            <div class="caption uppercase bold">
                                                <i class="fa fa-cogs"></i> Hoạt động </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="row">

                                                <div class="col-md-12 uppercase">
                                                    <a href="{{ route('user-send-mail',$user->id) }}" class="btn btn-success btn-lg btn-block"><i class="fa fa-envelope-open"></i> Gửi email</a>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="portlet box green">
                                        <div class="portlet-title">
                                            <div class="caption uppercase bold">
                                                <i class="fa fa-cog"></i> Cập nhật hồ sơ </div>
                                        </div>
                                        <div class="portlet-body">

                                            <form action="{{ route('user-details-update') }}" method="post">

                                                {!! csrf_field() !!}

                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <div class="row uppercase">

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="col-md-12"><strong>Tên</strong></label>
                                                            <div class="col-md-12">
                                                                <input class="form-control input-lg" name="name" value="{{ $user->name }}" type="text">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="col-md-12"><strong>Email</strong></label>
                                                            <div class="col-md-12">
                                                                <input class="form-control input-lg" name="email" value="{{ $user->email }}" type="text">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="col-md-12"><strong>Điện thoại</strong></label>
                                                            <div class="col-md-12">
                                                                <input class="form-control input-lg" name="phone" value="{{ $user->phone }}" type="text">
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div><!-- row -->

                                                <br><br>
                                                <div class="row uppercase">


                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="col-md-12"><strong>TRẠNG THÁI</strong></label>
                                                            <div class="col-md-12">
                                                                <input data-toggle="toggle" {{ $user->status == 0 ? 'checked' : ''}} data-onstyle="success" data-size="large" data-offstyle="danger" data-on="Active" data-off="Blocked"  data-width="100%" type="checkbox" name="status">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="col-md-12"><strong>EMAIL XÁC THỰC</strong></label>
                                                            <div class="col-md-12">
                                                                <input data-toggle="toggle" {{ $user->email_verify == 1 ? 'checked' : ''}} data-onstyle="success" data-size="large" data-offstyle="danger" data-on="Verified" data-off="Not Verified"  data-width="100%" type="checkbox" name="email_verify">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="col-md-12"><strong>XÁC NHẬN ĐIỆN THOẠI</strong></label>
                                                            <div class="col-md-12">
                                                                <input data-toggle="toggle" {{ $user->phone_verify == 1 ? 'checked' : ''}} data-onstyle="success" data-size="large" data-offstyle="danger" data-on="Verified" data-off="Not Verified"  data-width="100%" type="checkbox" name="phone_verify">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div><!-- row -->

                                                <br><br>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn blue btn-block btn-lg">CẬP NHẬT</button>
                                                    </div>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div><!-- col-9 -->

                    </div>
                </div>

            </div>
        </div><!-- ROW-->

    @else

        <div class="text-center">
            <h3>Không tìm thấy người dùng</h3>
        </div>
    @endif


@endsection
@section('scripts')

    <script src="{{ asset('assets/admin/js/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.waypoints.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/admin/js/jquery.counterup.min.js') }}" type="text/javascript"></script>

@endsection

