@extends('layouts.dashboard')
@section('style')


@endsection
@section('content')



    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="icon-settings font-red-sunglo"></i>
                        <span class="caption-subject bold uppercase">Cổng thanh toán</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <div class="row">
                        <div class="table-scrollable">
                            <table class="table table-striped table-bordered table-advance table-hover table-responsive">
                                <thead>
                                <tr>
                                    <th>
                                        <i class="fa fa-picture-o"></i> Logo
                                    </th>
                                    <th>
                                        <i class="fa fa-credit-card"></i> Tên cổng
                                    </th>
                                    <th>
                                        Tỷ lệ chuyển đổi
                                    </th>
                                    <th>
                                        Tính phí mỗi giao dịch
                                    </th>

                                    <th>
                                        Trạng thái
                                    </th>
                                    <th>
                                        Hoạt động
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($gateways as $gateway)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('assets/images/') }}/{{$gateway->image}}" width="50">
                                        </td>
                                        <td>
                                            {{$gateway->name}}
                                        </td>
                                        <td>
                                            1 {!! $basic->currency  !!} = {{ $gateway->rate }} {{ $gateway->currency }}
                                        </td>
                                        <td>
                                            Đã Sửa: <strong>{{$gateway->fix}}</strong> <br/>   Phần trăm: <strong>{{$gateway->percent}} %</strong>
                                        </td>
                                        <td>
                                            {{ $gateway->status == "1" ? 'Active' : 'Deactive' }}
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-outline btn-circle btn-sm blue" data-toggle="modal" data-target="#viewModal{{$gateway->id}}">
                                                <i class="fa fa-eye"></i> Xem </a>
                                            <a href="" class="btn btn-outline btn-circle btn-sm purple" data-toggle="modal" data-target="#Modal{{$gateway->id}}">
                                                <i class="fa fa-edit"></i> Chỉnh Sửa </a>
                                        </td>

                                    </tr>
                                    <!--View Modal -->
                                    <div id="viewModal{{$gateway->id}}" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">{{$gateway->name}}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <h5>Logo</h5>
                                                        </div>

                                                        <div class="col-md-9">
                                                            <img src="{{ asset('assets/images/') }}/{{$gateway->image}}" class="img-responsive" width="80">
                                                        </div>

                                                    </div>

                                                    <div class="row">
                                                        <hr/>
                                                        <div class="col-md-3">
                                                            <h5>Tên cổng</h5>
                                                        </div>
                                                        <div class="col-md-9">
                                                            {{$gateway->name}}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <hr/>
                                                        <div class="col-md-3">
                                                            <h5>Tỷ lệ chuyển đổi</h5>
                                                        </div>
                                                        <div class="col-md-9">
                                                            1 {!! $basic->currency  !!} = {{ $gateway->rate }} {{ $gateway->currency }}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <hr/>
                                                        <div class="col-md-3">
                                                            <h5>Tính phí mỗi giao dịch</h5>
                                                        </div>
                                                        <div class="col-md-9">
                                                            Đã Sửa: <strong>{{$gateway->fix}}</strong> <br/>   Phần Trăm: <strong>{{$gateway->percent}} %</strong>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <hr/>
                                                        <div class="col-md-3">
                                                            <h5>Chi tiết thanh toán</h5>
                                                        </div>
                                                        <div class="col-md-9">
                                                            {!!  $gateway->val1 !!}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <hr/>
                                                        <div class="col-md-3">
                                                            <h5>Trạng thái</h5>
                                                        </div>
                                                        <div class="col-md-9">
                                                            {{ $gateway->status == "1" ? 'Active' : 'Deactive' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!--Edit Modal -->
                                    <div class="modal fade" id="Modal{{$gateway->id}}" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Chỉnh sửa {{$gateway->name}} Thông tin</h4>
                                                </div>
                                                <form role="form" method="POST" action="{{url('admin/manual-edit')}}/{{$gateway->id}}" enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    {{ method_field('put')}}
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <span class="btn green fileinput-button">
                                                                <i class="fa fa-plus"></i>
                                                                <span> Tải lên biểu trưng </span>
                                                                <input type="file" name="gateimg" class="form-control input-lg">
                                                            </span>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="name">Tên của Gateway</label>
                                                            <input type="text" value="{{$gateway->name}}" class="form-control" id="name" name="name" >
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="rate">Tỷ giá tiền tệ</label>
                                                            <div class="input-group mb15">
                                                                <span class="input-group-addon"><strong>1 {{ $basic->currency }} = </strong></span>
                                                                <input class="form-control" name="rate" value="{{ $gateway->rate }}" required="" type="text">
                                                                <span class="input-group-addon"><strong>{{ $gateway->currency }}</strong></span>
                                                            </div>
                                                        </div>

                                                        <hr/>

                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label for="fix">Phí cố định cho giao dịch</label>
                                                                    <input type="text" value="{{$gateway->fix}}" class="form-control" id="fix" name="fix" >
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="percent">Phần trăm phí giao dịch</label>
                                                                    <input type="text" value="{{$gateway->percent}}" class="form-control" id="percent" name="percent" >
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="val1">thông tin tài khoản</label>
                                                            <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
                                                        </div>

                                                        <hr/>
                                                        <div class="form-group">
                                                            <label for="status">Trạng thái</label>
                                                            <select class="form-control" name="status">
                                                                <option value="1" {{ $gateway->status == "1" ? 'selected' : '' }}>Kích hoạt</option>
                                                                <option value="0" {{ $gateway->status == "0" ? 'selected' : '' }}>Hủy kích hoạt</option>
                                                            </select>

                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Cập nhật</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <tbody>
                            </table>
                        </div>

                    </div><!-- row -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

    <script src="{{ asset('assets/pages/scripts/components-bootstrap-switch.min.js') }}" type="text/javascript"></script>

@endsection