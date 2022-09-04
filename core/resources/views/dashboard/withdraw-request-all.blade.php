@extends('layouts.dashboard')
@section('content')


    <div class="row">
        <div class="col-md-12">


            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                    </div>
                    <div class="tools"> </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="sample_1">

                        <thead>
                        <tr>
                            <th>Ngày</th>
                            <th>Trx ID</th>
                            <th>Tài Khoản</th>
                            <th>Loại</th>
                            <th>Đồng Tiền / Phương Pháp</th>
                            <th>Số Lượng</th>
                            <th>Trạng Thái</th>
                            <th>Hoạt Động</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php $i=0;@endphp
                        @foreach($log as $p)
                            @php $i++;@endphp
                            <tr>
                                <td>{{ $p->created_at->format('d M Y')  }}</td>
                                <td>{{ $p->transaction_id }}</td>
                                <td>{{ $p->user->username }}</td>
                                <td>{{ $p->type }}</td>
                                <td>
                                    @if($p->type == 'general')
                                        @php
                                            $currency = $basic->currency;
                                        @endphp
                                        {{ $p->method->name }}
                                    @elseif($p->type == 'coin')
                                        @php
                                            $wallet = App\UserData::findOrFail($p->method_id);
                                            $currency = isset($wallet->miner)?$wallet->miner->code:'';
                                        @endphp
                                        {{ $wallet->miner->code }}
                                    @endif
                                </td>
                                <td>{{ $p->amount }} - {{ $currency }}</td>
                                <td>
                                    @if($p->status == 0 )
                                        <span class="label label-warning bold uppercase"><i class="fa fa-spinner"></i> Chưa Giải Quyết</span>
                                    @elseif($p->status == 1)
                                        <span class="label label-success bold uppercase"><i class="fa fa-check"></i> Hoàn Thành</span>
                                    @elseif($p->status == 2)
                                        <span class="label label-danger bold uppercase"><i class="fa fa-times"></i> Hoàn Tiền</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('single-withdraw-view',$p->id) }}" class="btn btn-primary btn-xs bold uppercase">Xem</a>
                                    @if($p->status == 0)
                                        <a href="#" data-id="{{ $p->id }}" class="btn btn-success btn-xs bold uppercase confir">Xác nhận</a>
                                        <a href="#" data-id="{{ $p->id }}" class="btn btn-danger btn-xs bold uppercase refund">Hoàn Tiền</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div><!-- ROW-->
    <div class="modal fade" id="con" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><strong>Xác Nhận..!</strong> </h4>
                </div>

                <div class="modal-body">
                    <strong>Bạn có chắc chắn xác nhận việc rút tiền này không ..?</strong>
                </div>
                <div class="modal-footer">
                    <form method="post" action="{{ route('withdraw-confirm') }}" class="form-inline">
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" class="abir_id" value="0">
                        <button type="button" class="btn btn-default" data-dismiss="modal"> Đóng</button>
                        <button type="submit" class="btn btn-success"> Vâng tôi chắc chắn..!</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="ref" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"> <i class='fa fa-exclamation-triangle'></i><strong>Xác nhận ..!</strong> </h4>
                </div>

                <div class="modal-body">
                    <strong>Bạn có chắc chắn muốn Hoàn trả Khoản Rút tiền này ..?</strong>
                </div>
                <div class="modal-footer">
                    <form method="post" action="{{ route('withdraw-refund') }}" class="form-inline">
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" class="abir_id" value="0">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Đóng</button>
                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Vâng tôi chắc chắn..!</button>
                    </form>
                </div>

            </div>
        </div>
    </div>


@endsection
@section('scripts')

    <script>
        $(document).ready(function () {

            $(document).on("click", '.confir', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $(".abir_id").val(id);
                $('#con').modal();
            });

        });
        $(document).ready(function () {

            $(document).on("click", '.refund', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $(".abir_id").val(id);
                $('#ref').modal();
            });

        });
    </script>

@endsection
