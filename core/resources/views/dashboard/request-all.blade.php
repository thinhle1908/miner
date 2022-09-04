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
                    <table class="table table-striped table-bordered table-hover">

                        <thead>
                        <tr>
                            <th>ID#</th>
                            <th>Ngày yêu cầu</th>
                            <th>ID giao dịch</th>
                            <th>Tên tài khoản</th>
                            {{--<th>Email</th>--}}
                            <th>Phương thức gửi tiền</th>
                            <th>Khoản đặt cọc</th>
                            <th>Phí đặt cọc</th>
                            <th>Số lượng tịnh</th>
                            <th>Trạng thái</th>
                            <th>Hoạt động</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php $i=0;@endphp
                        @foreach($deposit as $p)
                            @php $i++;@endphp
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ date('d-F-Y h:i A',strtotime($p->created_at))  }}</td>
                                <td>#{{ $p->transaction_id }}</td>
                                <td>{{ $p->member->username }}</td>
{{--                                <td>{{ $p->member->email }}</td>--}}
                                <td>
                                    @if($p->payment_type == 1)
                                        <span class="label label-primary"><i class="fa fa-paypal"></i> Paypal</span>
                                    @elseif($p->payment_type == 2)
                                        <span class="label label-primary"><i class="fa fa-money"></i> Perfect Money</span>
                                    @elseif($p->payment_type == 3)
                                        <span class="label label-primary"><i class="fa fa-btc"></i> BTC - BlockChain</span>
                                    @elseif($p->payment_type == 4)
                                        <span class="label label-primary"><i class="fa fa-credit-card"></i> Credit Card</span>
                                    @else
                                        <span class="label label-primary bold"><i class="fa fa-bank"></i> {{ $p->bank->name }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($p->payment_type == 1 or $p->payment_type == 2 or $p->payment_type == 3 or $p->payment_type == 4)
                                        {{ $p->amount }} - USD
                                    @else
                                        {{ $p->amount }} - {{ $basic->currency }}
                                    @endif
                                </td>
                                <td>
                                    @if($p->payment_type == 1 or $p->payment_type == 2 or $p->payment_type == 3 or $p->payment_type == 4)
                                        {{ $p->charge }} - USD
                                    @else
                                        {{ $p->charge }} - {{ $basic->currency }}
                                    @endif
                                </td>
                                <td>{{ $p->net_amount }} - {{ $basic->currency }}</td>

                                   
                                 <td>
                                    @if($p->status == 1)
                                        <span class="label label-primary bold uppercase"><i class="fa fa-check"></i> Đã được phê duyệt</span>
                                    @elseif($p->status == 2)
                                            <span class="label label-danger bold uppercase"><i class="fa fa-times"></i> Hủy bỏ</span>
                                     @elseif($p->status == 0)
                                            <span class="label label-warning bold uppercase"><i class="fa fa-spinner"></i> Chưa giải quyết</span>
                                    @endif

                                   
                                    </td>
                                <td>
                                    <a href="{{ route('request-view',$p->id) }}" class="btn btn-sm btn-primary bold uppercase"><i class="fa fa-eye"></i> View</a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <div class="text-center">
                        {!! $deposit->links() !!}
                    </div>
                </div>
            </div>

        </div>
    </div><!-- ROW-->
    <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"> <i class='fa fa-trash'></i> <strong>Xác nhận ..!</strong></h4>
                </div>

                <div class="modal-body">
                    <strong>Bạn có chắc chắn Muốn Phê duyệt Yêu cầu Gửi tiền này ..?</strong>
                </div>

                <div class="modal-footer">
                    <form method="post" action="{{ route('manual-deposit-approve') }}" class="form-inline">
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" class="abir_id" value="0">

                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Đóng</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Đúng. Tôi chắc chắn.</button>
                    </form>
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


    <script>
        $(document).ready(function () {

            $(document).on("click", '.delete_button', function (e) {
                var id = $(this).data('id');
                $(".abir_id").val(id);

            });

        });
    </script>

@endsection
