@extends('layouts.dashboard')
@section('style')
    <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script>

    <script type="text/javascript">
        bkLib.onDomLoaded(function() { new nicEditor({fullPanel : true}).panelInstance('area1'); });
    </script>

@endsection
@section('content')

    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cog"></i> {{ $page_title }}
            </div>
            <div class="tools">
                <a href="javascript:;" class="collapse"> </a>
                <a href="javascript:;" class="remove"> </a>
            </div>
        </div>
        <div class="portlet-body">

            <div class="row">

                <div class="col-md-12">
                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-bookmark"></i>Mã ngắn</div>

                        </div>
                        <div class="portlet-body">
                            <div class="table-scrollable">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> MÃ SỐ </th>
                                        <th> MÔ TẢ </th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    <tr>
                                        <td> 1 </td>
                                        <td> <pre>@{{message}}</pre> </td>
                                        <td>Chi tiết Văn bản Từ Tập lệnh</td>
                                    </tr>

                                    <tr>
                                        <td> 2 </td>
                                        <td> <pre>@{{name}}</pre> </td>
                                        <td>Tên người dùng. Sẽ lấy từ cơ sở dữ liệu và sử dụng trong văn bản EMAIL</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- END SAMPLE TABLE PORTLET-->
                </div>

                <div class="col-md-12">
                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-info-circle"></i>Chi tiết Email</div>

                        </div>
                        <div class="portlet-body">

                            <form class="form-horizontal" action="{{ route('email-setting') }}" method="post" role="form">
                                {!! csrf_field() !!}
                                <div class="form-body">

                                    <div class="form-group">
                                        <label class="control-label"><strong style="text-transform: uppercase;margin-left: 15px;">Email được gửi từ</strong><br></label>
                                        <div class="col-md-12">
                                            <input class="form-control input-lg" name="from_email" value="{{ $basic->from_email }}" required type="text">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label"><strong style="text-transform: uppercase;margin-left: 15px;">Mẫu email</strong><br></label>
                                        <div class="col-md-12">
                                            <textarea id="area1" class="form-control" rows="30" name="email_body">{{ $basic->email_body }}</textarea>
                                        </div>
                                    </div>

                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn blue btn-block btn-lg"><i class="fa fa-send"></i> CẬP NHẬT</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
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

@endsection
