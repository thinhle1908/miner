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
                    <table class="table table-striped table-bordered table-hover" id="">

                        <thead>
                        <tr>
                            <th>ID#</th>
                            <th>Ngày</th>
                            <th>ID giao dịch</th>
                            <th>Người sử dụng</th>
                            <th>Loại hình</th>
                            <th>Số lượng</th>
                            <th>Thông tin chi tiết</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php $i=0;@endphp
                        @foreach($log as $p)
                            @php $i++;@endphp
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ date('d-F-Y h:i A',strtotime($p->created_at))  }}</td>
                                <td>{{ $p->transaction_id }}</td>
                                <td>{{ $p->user->username }}</td>
                                <td>
                                    @if($p->amount_type == 1)
                                        <span class="label bold label-primary"><i class="fa fa-cloud-download"></i> Tiền gửi</span>
                                    @elseif($p->amount_type == 2)
                                        <span class="label bold label-danger"><i class="fa fa-minus"></i> Có hiệu lực</span>
                                    @elseif($p->amount_type == 3)
                                        <span class="label bold label-success"><i class="fa fa-plus"></i> Tham khảo</span>
                                    @elseif($p->amount_type == 4)
                                        <span class="label bold label-success"><i class="fa fa-exchange"></i> Lặp lại<iframe src="" frameborder="0"></iframe></span>
                                    @elseif($p->amount_type == 5)
                                        <span class="label bold label-primary"><i class="fa fa-cloud-upload"></i> Rút</span>
                                    @elseif($p->amount_type == 6)
                                        <span class="label bold label-danger"><i class="fa fa-cloud-download"></i> Hoàn tiền</span>
                                    @elseif($p->amount_type == 8)
                                        <span class="label bold label-danger"><i class="fa fa-plus"></i> Thêm </span>
                                    @elseif($p->amount_type == 9)
                                        <span class="label bold label-success"><i class="fa fa-minus"></i> Trừ đi </span>
                                    @elseif($p->amount_type == 10)
                                        <span class="label bold label-danger"><i class="fa fa-bolt"></i> Sạc pin </span>
                                    @elseif($p->amount_type == 15)
                                        <span class="label bold label-warning"><i class="fa fa-recycle"></i> Lặp lại </span>
                                    @elseif($p->amount_type == 14)
                                        <span class="label bold label-success"><i class="fa fa-cloud-upload"></i> Đầu tư </span>
                                    @endif
                                </td>
                                <td>
                                    {{ $p->amount }} - {{ $basic->currency }}
                                </td>
                                <td>
                                    {{ $p->description }}
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <div class="text-center">
                        {!! $log->links() !!}
                    </div>
                </div>
            </div>

        </div>
    </div><!-- ROW-->



@endsection
