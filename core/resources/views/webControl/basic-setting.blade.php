@extends('layouts.dashboard')

@section('style')

    <link href="{{ asset('assets/admin/css/bootstrap-toggle.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet">

@endsection
@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <strong>{{ $page_title }}</strong>
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"> </a>
                    </div>
                </div>
                <div class="portlet-body">


                    {!! Form::model($basic,['route'=>['basic-update',$basic->id],'method'=>'PUT','role'=>'form','class'=>'form-horizontal','files'=>true]) !!}
                    <div class="form-body">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Tiêu Đề Trang</strong></label>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input class="form-control bold input-lg" name="title" value="{{ $basic->title }}" type="text" required>
                                            <span class="input-group-addon"><strong><i class="fa fa-file-text-o"></i></strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Màu trang web </strong></label>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input type="text" name="color" style="background: #{{ $basic->color }}" class="form-control bold input-lg" value="{{ $basic->color }}" required>
                                            <span class="input-group-addon"><i class="fa fa-tint"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Ngày bắt đầu trang web </strong></label>
                                    <div class="col-md-12">
                                        <div class='input-group date' id='datetimepicker1'>
                                            <input type="text" name="start_date" class="form-control bold input-lg" value="{{ $basic->start_date }}">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;"> TIỀN TỆ CƠ BẢN</strong></label>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input class="form-control bold input-lg" name="currency" value="{{ $basic->currency }}" type="text" required>
                                            <span class="input-group-addon"><strong><i class="fa fa-money"></i></strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Ký Hiệu Tiền Tệ</strong></label>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input class="form-control bold input-lg" name="symbol" value="{{ $basic->symbol }}" type="text" required>
                                            <span class="input-group-addon"><strong><i class="fa fa-exclamation-circle"></i></strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">QUYẾT ĐỊNH SAU KHI ĐIỂM</strong></label>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input class="form-control bold input-lg" name="deci" value="{{ $basic->deci }}" type="text" required>
                                            <span class="input-group-addon"><strong><i class="fa fa-arrows-h"></i></strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Đăng ký người dùng</strong></label>
                                    <div class="col-md-12">
                                        <input data-toggle="toggle" {{ $basic->user_reg == '1' ? 'checked' : '' }} data-onstyle="success" data-offstyle="danger" data-width="100%" data-size="large" type="checkbox" name="user_reg">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Email xác thực</strong></label>
                                    <div class="col-md-12">
                                        <input data-toggle="toggle" {{ $basic->email_verify == '1' ? 'checked' : '' }} data-onstyle="success" data-offstyle="danger" data-width="100%" data-size="large" type="checkbox" name="email_verify">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Xác minh điện thoại</strong></label>
                                    <div class="col-md-12">
                                        <input data-toggle="toggle" {{ $basic->phone_verify == '1' ? 'checked' : '' }} data-onstyle="success" data-offstyle="danger" data-width="100%" data-size="large" type="checkbox" name="phone_verify">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Trạng thái rút tiền</strong></label>
                                    <div class="col-md-12">
                                        <input data-toggle="toggle" {{ $basic->withdraw_status == '1' ? 'checked' : '' }} data-onstyle="success" data-offstyle="danger" data-width="100%" data-size="large" type="checkbox" name="withdraw_status">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">thông báo có email</strong></label>
                                    <div class="col-md-12">
                                        <input data-toggle="toggle" {{ $basic->email_notify == '1' ? 'checked' : '' }} data-onstyle="success" data-offstyle="danger" data-width="100%" data-size="large" type="checkbox" name="email_notify">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Thông báo qua điện thoại</strong></label>
                                    <div class="col-md-12">
                                        <input data-toggle="toggle" {{ $basic->phone_notify == '1' ? 'checked' : '' }} data-onstyle="success" data-offstyle="danger" data-width="100%" data-size="large" type="checkbox" name="phone_notify">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Đăng nhập Facebook</strong></label>
                                    <div class="col-md-12">
                                        <input data-toggle="toggle" {{ $basic->fb_login == '1' ? 'checked' : '' }} data-onstyle="success" data-offstyle="danger" data-width="100%" data-size="large" type="checkbox" name="fb_login">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">ID ứng dụng (Đăng nhập Facebook)</strong></label>
                                    <div class="col-md-12">
                                        <input class="form-control bold input-lg" name="facebook_app" value="{{ $facebook->client_id }}" type="text" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">BÍ MẬT Ứng dụng (Đăng nhập Facebook)</strong></label>
                                    <div class="col-md-12">
                                        <input class="form-control bold input-lg" name="facebook_secret" value="{{ $facebook->client_secret }}" type="text" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Đăng nhập Google</strong></label>
                                    <div class="col-md-12">
                                        <input data-toggle="toggle" {{ $basic->g_login == '1' ? 'checked' : '' }} data-onstyle="success" data-offstyle="danger" data-width="100%" data-size="large" type="checkbox" name="g_login">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">ID khách hàng (Đăng nhập Google Plus)</strong></label>
                                    <div class="col-md-12">
                                        <input class="form-control bold input-lg" name="google_app" value="{{ $google->client_id }}" type="text" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">BÍ MẬT ứng dụng khách (Đăng nhập Google Plus)</strong></label>
                                    <div class="col-md-12">
                                        <input class="form-control bold input-lg" name="google_secret" value="{{ $google->client_secret }}" type="text" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Tính phí mỗi lần rút tiền xu</strong></label>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input class="form-control bold input-lg" name="withdraw_charge" value="{{ $basic->withdraw_charge }}" type="text" required>
                                            <span class="input-group-addon"><strong>%</strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Xác minh reCaptcha của Google</strong></label>
                                    <div class="col-md-12">
                                        <input data-toggle="toggle" {{ $basic->google_recap == '1' ? 'checked' : '' }} data-onstyle="success" data-offstyle="danger" data-width="100%" data-size="large" type="checkbox" name="google_recap">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Khóa trang web reCaptcha của Google</strong></label>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input class="form-control bold input-lg" name="google_site_key" value="{{ $basic->google_site_key }}" type="text" required>
                                            <span class="input-group-addon"><strong><i class="fa fa-key"></i></strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Khóa bí mật reCaptcha của Google</strong></label>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input class="form-control bold input-lg" name="google_secret_key" value="{{ $basic->google_secret_key }}" type="text" required>
                                            <span class="input-group-addon"><strong><i class="fa fa-key"></i></strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br> <br>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn blue btn-block btn-lg"><i class="fa fa-send"></i> Cập Nhật</button>
                            </div>
                        </div>
                        <br>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div><!---ROW-->


@endsection
@section('scripts')


    @if (session('alert'))

        <script type="text/javascript">

            $(document).ready(function(){

                swal("Sorry!", "{!! session('alert') !!}", "error");

            });

        </script>

    @endif


    <script src="{{ asset('assets/admin/js/bootstrap-toggle.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

    <script type="text/javascript">
        $(function () {
            $('#datetimepicker1').datetimepicker({
                format: 'YYYY-MM-DD hh:mm:ss'
            });
        });
    </script>

    <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script>

    <script type="text/javascript">
        bkLib.onDomLoaded(function() { new nicEditor({fullPanel : true}).panelInstance('area1'); });
    </script>

@endsection
