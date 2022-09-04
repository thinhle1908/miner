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
                        <strong><i class="fa fa-info-circle"></i> {{ $page_title }}</strong>
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"> </a>
                    </div>
                </div>
                <div class="portlet-body" style="overflow: hidden">
                    {!! Form::model($bank,['route'=>['withdraw-update',$bank->id],'method'=>'put','class'=>'form-horizontal','files'=>true]) !!}
                    <div class="form-body">


                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Tên phương pháp</strong></label>
                                    <div class="col-sm-12">
                                        <div class="input-group mb15">
                                            <input class="form-control input-lg bold" name="name" value="{{ $bank->name }}" required type="text" placeholder="Tên phương pháp">
                                            <span class="input-group-addon"><i class="fa fa-cloud-upload"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Thay đổi hình ảnh phương pháp</strong></label>
                                    <div class="col-sm-12">
                                        <span class="btn green fileinput-button">
                                            <i class="fa fa-plus"></i>
                                            <span> Tải lên ảnh mới </span>
                                            <input class="form-control input-lg" name="image" value="" type="file" >
                                        </span>

                                        {{--<div class="input-group mb15">--}}
                                            {{--<input class="form-control input-lg bold" name="image" value="" type="file" >--}}
                                            {{--<span class="input-group-addon"><i class="fa fa-picture-o"></i></span>--}}
                                        {{--</div>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Tối thiểu </strong></label>
                                    <div class="col-sm-12">
                                        <div class="input-group mb15">
                                            <input class="form-control input-lg bold" name="withdraw_min" value="{{ $bank->withdraw_min }}" required type="text" placeholder="Tối thiểu">
                                            <span class="input-group-addon"><strong>{{ $basic->currency }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Tối đa </strong></label>
                                    <div class="col-sm-12">
                                        <div class="input-group mb15">
                                            <input class="form-control input-lg bold" name="withdraw_max" value="{{ $bank->withdraw_max }}" required type="text" placeholder="Tối đa">
                                            <span class="input-group-addon"><strong>{{ $basic->currency }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Thời gian xử lý </strong></label>
                                    <div class="col-sm-12">
                                        <div class="input-group mb15">
                                            <input class="form-control input-lg bold" name="duration" value="{{ $bank->duration }}" required type="text" placeholder="Thời gian xử lý">
                                            <span class="input-group-addon"><strong>Ngày</strong></span>
                                        </div>
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
                                            <input class="form-control input-lg bold" name="fix" value="{{ $bank->fix }}" required type="text" placeholder="Khắc phục phí">
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
                                            <input class="form-control input-lg bold" name="percent" value="{{ $bank->percent }}" required type="text" placeholder="Phần trăm">
                                            <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Trạng thái </strong></label>
                                    <div class="col-sm-12">
                                        <input data-toggle="toggle" {{ $bank->status == 1 ? 'checked' : '' }} data-onstyle="success" data-offstyle="danger" data-width="100%" data-size="large" type="checkbox" name="status">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-primary btn-block uppercase btn-lg"><i class="fa fa-send"></i> Cập nhật phương thức rút tiền</button>
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