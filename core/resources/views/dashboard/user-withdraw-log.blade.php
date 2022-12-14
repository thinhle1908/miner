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
                            <th>ID#</th>
                            <th>Ngày</th>
                            <th>ID giao dịch</th>
                            <th>Phương thức Rút tiền</th>
                            <th>Withdraw Amount</th>
                            <th>Trạng thái</th>
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
                                <td>{{ $p->method->name }}</td>
                                <td>{{ $p->amount }} - {{ $basic->currency }}</td>
                                <td>
                                    @if($p->status == 1 )
                                        <span class="label bold label-warning"><i class="fa fa-spinner"></i> Chưa giải quyết</span>
                                    @elseif($p->status == 2)
                                        <span class="label bold label-success"><i class="fa fa-check"></i> Hoàn thành</span>
                                    @elseif($p->status == 3)
                                        <span class="label bold label-danger"><i class="fa fa-times"></i> Hoàn Tiền</span>
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



@endsection
