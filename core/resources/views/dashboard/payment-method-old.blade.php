@extends('layouts.dashboard')
@section('style')
    <link href="{{ asset('assets/admin/css/bootstrap-toggle.min.css') }}" rel="stylesheet">

@endsection
@section('content')



    <div class="portlet box blue-hoki">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-money"></i>Phương Thức Thanh Toán</div>
            <div class="tools">
                <a href="javascript:;" class="collapse"> </a>
                <a href="javascript:;" class="reload"> </a>
                <a href="javascript:;" class="remove"> </a>
            </div>
        </div>

        <div class="portlet-body" style="overflow: hidden">
            {!! Form::open(['method'=>'post','files'=>true]) !!}
            <div class="col-md-3 col-sm-12">
                <div class="portlet box blue-hoki">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-paypal"></i>Paypal</div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>
                            <a href="javascript:;" class="remove"> </a>
                        </div>
                    </div>
                    <div class="portlet-body">


                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h1 class="panel-title" style="text-transform: uppercase; font-weight: bold;"><i class="fa fa-cc-paypal"></i>Chi tiết PayPal</h1>
                            </div>
                            <div class="panel-body no-side-padding">

                                <div class="form-group clearfix">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Hình ảnh hiển thị</strong></label>
                                    <div class="col-md-12">
                                        <span class="btn green fileinput-button">
                                                <i class="fa fa-plus"></i>
                                                <span> Tải lên biểu tượng mới </span>
                                                <input type="file" name="paypal_image" class="form-control input-lg">
                                            </span>
                                        <br>
                                        <b style="color: red;">Kích thước hình vuông (400X400) Hình ảnh JPG được đề xuất</b>
                                        <br>
                                        <br>
                                    </div>
                                    <div class="col-md-10 col-md-offset-1">
                                        <img src="{{ asset('assets/images') }}/{{ $paypal->image }}" alt="Display Image" style="width: 100%;">
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <label class="col-md-12"><strong style="text-transform: uppercase; margin-top: 5px;">Tên hiển thị</strong></label>
                                    <div class="col-md-12">
                                        <input class="form-control" name="paypal_name" value="{{ $paypal->name }}" type="text" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase; margin-top: 5px">Tỷ lệ chuyển đổi</strong></label>
                                    <div class="col-md-12">
                                        <div class="input-group mb15">
                                            <span class="input-group-addon small12"><strong>1 USD = </strong></span>
                                            <input class="form-control" name="paypal_rate" value="{{ $paypal->rate }}" type="text" required>
                                            <span class="input-group-addon small12"><strong>{{ $basic->currency }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h1 class="panel-title" style="text-transform: uppercase; font-weight: bold;">Tính phí mỗi giao dịch</h1>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-12"><strong style="text-transform: uppercase;">ĐÃ SỬA</strong></label>
                                            <div class="col-md-12">
                                                <div class="input-group mb15">
                                                    <input class="form-control" name="paypal_fix" value="{{ $paypal->fix }}" required type="text">
                                                    <span class="input-group-addon"><strong>{{ $basic->currency }}</strong></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-12"><strong style="text-transform: uppercase;">PHẦN TRĂM</strong></label>
                                            <div class="col-md-12">
                                                <div class="input-group mb15">
                                                    <input class="form-control" name="paypal_percent" value="{{ $paypal->percent }}" required type="text">
                                                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div><!-- row 2nd   -->
                            </div>
                        </div>

                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h1 class="panel-title" style="text-transform: uppercase; font-weight: bold;">Mô tả thanh toán</h1>
                            </div>
                            <div class="panel-body">
                                <div class="form-group" style="margin-top: 40px;margin-bottom: 135px;">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Email Doanh nghiệp PayPal</strong></label>
                                    <div class="col-md-12">
                                        <div class="input-group mb15">
                                            <input class="form-control" name="paypal_email" value="{{ $paypal->val1 }}" required type="text">
                                            <span class="input-group-addon"><b>@</b></span>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">TRẠNG THÁI</strong></label>
                                    <div class="col-md-12">
                                        <input data-toggle="toggle" {{ $paypal->status == 1 ? 'checked' : '' }} data-onstyle="success" data-offstyle="danger" data-width="100%" type="checkbox" name="paypal_status">
                                    </div>
                                </div>
                                <br>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="portlet box blue-hoki">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-money"></i>Tiền hoàn hảo </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>
                            <a href="javascript:;" class="remove"> </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h1 class="panel-title" style="text-transform: uppercase; font-weight: bold;"><strong><i class="fa fa-credit-card-alt"></i> Tiền hoàn hảo</strong></h1>
                            </div>
                            <div class="panel-body no-side-padding">

                                <div class="form-group clearfix">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Hình ảnh hiển thị</strong></label>
                                    <div class="col-md-12">
                                        <span class="btn green fileinput-button">
                                                <i class="fa fa-plus"></i>
                                                <span> Tải lên biểu tượng mới </span>
                                                <input type="file" name="perfect_image" class="form-control input-lg">
                                            </span>
                                        <br>
                                        <b style="color: red;">Kích thước hình vuông (400X400) Hình ảnh JPG được đề xuất</b>
                                        <br>
                                        <br>
                                    </div>
                                    <div class="col-md-10 col-md-offset-1">
                                        <img src="{{ asset('assets/images') }}/{{ $perfect->image }}" alt="Display Image" style="width: 100%;">
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Tên hiển thị</strong></label>
                                    <div class="col-md-12">
                                        <input class="form-control" name="perfect_name" value="{{ $perfect->name }}" required type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Tỷ lệ chuyển đổi</strong></label>
                                    <div class="col-md-12">
                                        <div class="input-group mb15">
                                            <span class="input-group-addon small12"><strong>1 USD = </strong></span>
                                            <input class="form-control" name="perfect_rate" value="{{ $perfect->rate }}" type="text" required>
                                            <span class="input-group-addon small12"><strong>{{ $basic->currency }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h1 class="panel-title" style="text-transform: uppercase; font-weight: bold;">Tính phí mỗi giao dịch</h1>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-12"><strong style="text-transform: uppercase;">ĐÃ SỬA</strong></label>
                                            <div class="col-md-12">
                                                <div class="input-group mb15">
                                                    <input class="form-control" name="perfect_fix" value="{{ $perfect->fix }}" required type="text">
                                                    <span class="input-group-addon"><strong>{{ $basic->currency }}</strong></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-12"><strong style="text-transform: uppercase;">PHẦN TRĂM</strong></label>
                                            <div class="col-md-12">
                                                <div class="input-group mb15">
                                                    <input class="form-control" name="perfect_percent" value="{{ $perfect->percent }}" required type="text">
                                                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div><!-- row 2nd   -->
                            </div>
                        </div>
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h1 class="panel-title" style="text-transform: uppercase; font-weight: bold;">Mô tả thanh toán</h1>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Tài khoản Perfect Money USD</strong></label>
                                    <div class="col-md-12" style="margin-bottom: 21px;">
                                        <div class="input-group mb15">
                                            <input class="form-control" name="perfect_account" value="{{ $perfect->val1 }}" type="text">
                                            <span class="input-group-addon"><i class="fa fa-send"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Cụm mật khẩu thay thế Perfect Money  </strong></label>
                                    <div class="col-md-12">
                                        <div class="input-group mb15">
                                            <input class="form-control" name="perfect_alternate" value="{{ $perfect->val2 }}" type="text">
                                            <span class="input-group-addon"><i class="fa fa-bolt"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">TRẠNG THÁI</strong></label>
                                    <div class="col-md-12">
                                        <input data-toggle="toggle" {{ $perfect->status == 1 ? 'checked' : '' }} data-onstyle="success" data-offstyle="danger" data-width="100%" type="checkbox" name="perfect_status">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="portlet box blue-hoki">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-btc"></i>BTC ( BlockChain )</div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>
                            <a href="javascript:;" class="remove"> </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h1 class="panel-title" style="text-transform: uppercase; font-weight: bold;"><strong><i class="fa fa-btc"></i> BlockChain - (BITCOIN)</strong></h1>
                            </div>
                            <div class="panel-body no-side-padding">

                                <div class="form-group clearfix">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Hình ảnh hiển thị</strong></label>
                                    <div class="col-md-12">
                                        <span class="btn green fileinput-button">
                                                <i class="fa fa-plus"></i>
                                                <span> Upload New Icon </span>
                                                <input type="file" name="btc_image" class="form-control input-lg">
                                            </span>
                                        <br>
                                        <b style="color: red;">Kích thước hình vuông (400X400) Hình ảnh JPG được đề xuất</b>
                                        <br>
                                        <br>
                                    </div>
                                    <div class="col-md-12">
                                        <img src="{{ asset('assets/images') }}/{{ $btc->image }}" alt="Display Image" style="width: 100%;">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Tên hiển thị</strong></label>
                                    <div class="col-md-12">
                                        <input class="form-control" name="btc_name" value="{{ $btc->name }}" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Tỷ lệ chuyển đổi</strong></label>
                                    <div class="col-md-12">
                                        <div class="input-group mb15">
                                            <span class="input-group-addon small12"><strong>1 USD = </strong></span>
                                            <input class="form-control" name="btc_rate" value="{{ $btc->rate }}" type="text" required>
                                            <span class="input-group-addon small12"><strong>{{ $basic->currency }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h1 class="panel-title" style="text-transform: uppercase; font-weight: bold;">Tính phí mỗi giao dịch</h1>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-12"><strong style="text-transform: uppercase;">ĐÃ SỬA</strong></label>
                                            <div class="col-md-12">
                                                <div class="input-group mb15">
                                                    <input class="form-control" name="btc_fix" value="{{ $btc->fix }}" required type="text">
                                                    <span class="input-group-addon"><strong>{{ $basic->currency }}</strong></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-12"><strong style="text-transform: uppercase;">PHẦN TRĂM</strong></label>
                                            <div class="col-md-12">
                                                <div class="input-group mb15">
                                                    <input class="form-control" name="btc_percent" value="{{ $btc->percent }}" required type="text">
                                                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div><!-- row 2nd   -->
                            </div>
                        </div>
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h1 class="panel-title" style="text-transform: uppercase; font-weight: bold;">Mô tả thanh toánn</h1>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Khóa API BitCoin</strong></label>
                                    <div class="col-md-12">
                                        <div class="input-group mb15">
                                            <input class="form-control" name="btc_api" value="{{ $btc->val1 }}" type="text">
                                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <br>
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">BitCoin XPUB Code  </strong></label>
                                    <div class="col-md-12">
                                        <div class="input-group mb15">
                                            <input class="form-control" name="btc_xpub" value="{{ $btc->val2 }}" type="text">
                                            <span class="input-group-addon"><i class="fa fa-code"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">TRẠNG THÁI</strong></label>
                                    <div class="col-md-12">
                                        <input data-toggle="toggle" {{ $btc->status == 1 ? 'checked' : '' }} data-onstyle="success" data-offstyle="danger" data-width="100%" type="checkbox" name="btc_status">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="portlet box blue-hoki">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-credit-card"></i>Thẻ tín dụng </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>
                            <a href="javascript:;" class="remove"> </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h1 class="panel-title" style="text-transform: uppercase; font-weight: bold;"><strong><i class="fa fa-cc-stripe"></i> Stripe (CARD)</strong></h1>
                            </div>
                            <div class="panel-body no-side-padding">

                                <div class="form-group clearfix">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Hình ảnh hiển thị</strong></label>
                                    <div class="col-md-12">
                                        <span class="btn green fileinput-button">
                                                <i class="fa fa-plus"></i>
                                                <span>Tải lên biểu tượng mới </span>
                                                <input type="file" name="stripe_image" class="form-control input-lg">
                                            </span>
                                        <br>
                                        <b style="color: red;">Kích thước hình vuông (400X400) Hình ảnh JPG được đề xuất</b>
                                        <br>
                                        <br>
                                    </div>
                                    <div class="col-md-12">
                                        <img src="{{ asset('assets/images') }}/{{ $stripe->image }}" alt="Display Image" style="width: 100%;">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Tên hiển thị</strong></label>
                                    <div class="col-md-12">
                                        <input class="form-control" name="stripe_name" value="{{ $stripe->name }}" type="text">
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Tỷ lệ chuyển đổi</strong></label>
                                    <div class="col-md-12">
                                        <div class="input-group mb15">
                                            <span class="input-group-addon small12"><strong>1 USD = </strong></span>
                                            <input class="form-control" name="stripe_rate" value="{{ $stripe->rate }}" type="text" required>
                                            <span class="input-group-addon small12"><strong>{{ $basic->currency }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h1 class="panel-title" style="text-transform: uppercase; font-weight: bold;">Tính phí mỗi giao dịch</h1>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-12"><strong style="text-transform: uppercase;">ĐÃ SỬA</strong></label>
                                            <div class="col-md-12">
                                                <div class="input-group mb15">
                                                    <input class="form-control" name="stripe_fix" value="{{ $stripe->fix }}" required type="text">
                                                    <span class="input-group-addon"><strong>{{ $basic->currency }}</strong></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-12"><strong style="text-transform: uppercase;">PHẦN TRĂM</strong></label>
                                            <div class="col-md-12">
                                                <div class="input-group mb15">
                                                    <input class="form-control" name="stripe_percent" value="{{ $stripe->percent }}" required type="text">
                                                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div><!-- row 2nd   -->
                            </div>
                        </div>
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h1 class="panel-title" style="text-transform: uppercase; font-weight: bold;">Mô tả thanh toán</h1>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">CHÌA KHOÁ BÍ MẬT</strong></label>
                                    <div class="col-md-12">
                                        <div class="input-group mb15">
                                            <input class="form-control" name="stripe_secret" value="{{ $stripe->val1 }}" type="text">
                                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">KHÓA NHÀ XUẤT BẢN</strong></label>
                                    <div class="col-md-12">
                                        <div class="input-group mb15">
                                            <input class="form-control" name="stripe_publishable" value="{{ $stripe->val2 }}" type="text">
                                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">TRẠNG THÁI</strong></label>
                                    <div class="col-md-12">
                                        <input data-toggle="toggle" {{ $stripe->status == 1 ? 'checked' : '' }} data-onstyle="success" data-offstyle="danger" data-width="100%" type="checkbox" name="stripe_status">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-info btn-block"><i class="fa fa-send"></i> <strong>Lưu thay đổi</strong></button>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>


@endsection
@section('scripts')
    <script src="{{ asset('assets/admin/js/bootstrap-toggle.min.js') }}"></script>

@endsection