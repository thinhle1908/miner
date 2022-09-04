@extends('layouts.dashboard')
@section('style')

    <link href="{{ asset('assets/admin/css/bootstrap-toggle.min.css') }}" rel="stylesheet">


@endsection
@section('content')


    <div class="row">
        <div class="col-md-12">

            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <strong class="uppercase"><i class="fa fa-info-circle"></i> {{ $page_title }}</strong>
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"> </a>
                    </div>
                </div>
                <div class="portlet-body" style="overflow: hidden">
                    {!! Form::open(['method'=>'post','class'=>'form-horizontal','files'=>true]) !!}
                    <div class="form-body">


                        <div class="row">

                            <div class="col-md-5">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Tên phương pháp</strong></label>
                                    <div class="col-sm-12">
                                        <div class="input-group mb15">
                                            <input class="form-control input-lg bold" name="name" value="" required type="text" placeholder="Tên phương pháp">
                                            <span class="input-group-addon"><i class="fa fa-bank"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Ảnh phương pháp</strong></label>
                                    <div class="col-sm-12">
                                        <span class="btn green fileinput-button">
                                            <i class="fa fa-plus"></i>
                                            <span> Upload New Photo </span>
                                            <input class="form-control input-lg bold" name="image" value="" required type="file" >
                                        </span>
                                        {{--<div class="input-group mb15">--}}
                                            {{--<input class="form-control input-lg bold" name="image" value="" required type="file" >--}}
                                            {{--<span class="input-group-addon"><i class="fa fa-picture-o"></i></span>--}}
                                        {{--</div>--}}
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Phương thức tiền tệ</strong></label>
                                    <div class="col-sm-12">
                                        <div class="input-group mb15">
                                            <input class="form-control input-lg bold" name="currency" value="" required type="text" placeholder="Tiền tệ">
                                            <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Tỷ lệ tiền tệ</strong></label>
                                    <div class="col-sm-12">
                                        <div class="input-group mb15">
                                            <span class="input-group-addon"><strong>1 {{ $basic->currency }} = </strong></span>
                                            <input class="form-control input-lg bold" name="rate" value="" required type="text" >
                                            <span class="input-group-addon"><strong>Phương thức tiền tệ</strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-12"><strong style="text-transform: uppercase;">Chi tiết thanh toán</strong></label>
                                            <div class="col-sm-12">
                                        <textarea name="val1" rows="8"
                                                  class="form-control bold input-lg" required
                                                  placeholder="Chi tiết thanh toán ( Where User Pay You )"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-md-12"><strong style="text-transform: uppercase;">Khắc phục phí </strong></label>
                                            <div class="col-sm-12">
                                                <div class="input-group mb15">
                                                    <input class="form-control input-lg bold" name="fix" value=""
                                                           required type="text" placeholder="Khắc phục phí">
                                                    <span class="input-group-addon"><strong>{{ $basic->currency }}</strong></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-md-12"><strong style="text-transform: uppercase;">Phần trăm </strong></label>
                                            <div class="col-sm-12">
                                                <div class="input-group mb15">
                                                    <input class="form-control input-lg bold" name="percent" value=""
                                                           required type="text" placeholder="Phần trăm">
                                                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-md-12"><strong
                                                        style="text-transform: uppercase;">Trạng thái </strong></label>
                                            <div class="col-sm-12">
                                                <input data-toggle="toggle" checked data-onstyle="success"
                                                       data-offstyle="danger" data-width="100%" data-size="large"
                                                       type="checkbox" name="status">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-primary btn-block btn-lg"><i class="fa fa-send"></i>Thêm phương pháp thủ công</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


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

@endsection