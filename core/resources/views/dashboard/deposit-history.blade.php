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
                        <table class="table table-striped table-bordered table-hover" id="samle_1">

                            <thead>
                            <tr>
                                <th>ID#</th>
                                <th>Ngày Gửi Tiền</th>
                                <th>ID Giao Dịch</th>
                                <th>Tên Người Dùng Gửi Tiền</th>
                                <th>Phương Thức Gửi Tiền</th>
                                <th>Gửi Số Tiền</th>
                                <th>Phí Đặt Cọc</th>
                                <th>Khoản Đặt Cọc</th>
                                <th>Trạng Thái</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $i=0;@endphp
                            @foreach($deposit as $p)
                                @php $i++;@endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ date('d-F-Y h:i A',strtotime($p->created_at))  }}</td>
                                    <td>{{ $p->transaction_id }}</td>
                                    <td>{{ $p->member->username }}</td>
                                    <td>
                                        @if($p->payment_type == 1)
                                            <span class="label label-primary  bold uppercase"><i class="fa fa-paypal"></i> Paypal</span>
                                        @elseif($p->payment_type == 2)
                                            <span class="label label-primary  bold uppercase"><i class="fa fa-money"></i> Perfect Money</span>
                                        @elseif($p->payment_type == 3)
                                            <span class="label label-primary  bold uppercase"><i class="fa fa-btc"></i> BTC - BlockChain</span>
                                        @elseif($p->payment_type == 4)
                                            <span class="label label-primary  bold uppercase"><i class="fa fa-credit-card"></i> Credit Card</span>
                                        @elseif($p->payment_type == 5)
                                            <span class="label label-primary  bold uppercase"><i class="fa fa-btc"></i> CoinPayments</span>
                                        @elseif($p->payment_type == 6)
                                            <span class="label label-primary  bold uppercase"><i class="fa fa-btc"></i> Skrill</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($p->payment_type == 1 or $p->payment_type == 2 or $p->payment_type == 3 or $p->payment_type == 4 or $p->payment_type == 5 or $p->payment_type == 6)
                                            {{ round(($p->net_amount / $p->rate),$basic->deci) }} - USD
                                        @endif
                                    </td>
                                    <td>
                                        @if($p->payment_type == 1 or $p->payment_type == 2 or $p->payment_type == 3 or $p->payment_type == 4 or $p->payment_type == 5 or $p->payment_type == 6)
                                            {{ round(($p->charge / $p->rate),$basic->deci) }} - USD
                                        @endif
                                    </td>
                                    <td>
                                        @if($p->payment_type == 1 or $p->payment_type == 2 or $p->payment_type == 3 or $p->payment_type == 4 or $p->payment_type == 5 or $p->payment_type == 6)
                                            {{ $p->amount }} - {{ $basic->currency }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($p->status == 1)
                                            <span class="label label-primary  bold uppercase"><i class="fa fa-check"></i> Completed</span>
                                        @elseif($p->status == 2)
                                            <span class="label label-danger  bold uppercase"><i class="fa fa-times"></i> Cancel</span>
                                        @else
                                            <span class="label label-warning  bold uppercase"><i class="fa fa-spinner"></i> Pending</span>
                                        @endif
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



@endsection
