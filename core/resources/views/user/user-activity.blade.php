@extends('layouts.user-frontend.user-dashboard')
@section('content')
@include('layouts.breadcam')

<div class="content_padding">
    <div class="container user-dashboard-body">

        <div class="row">
            <div class="col-md-12">

                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                    @if($logs && count($logs))

                        @foreach($logs as $log)

                            @php

                                switch ($log->status) {
                                    case 'requested':
                                        $panel = 'primary';
                                        $user = \App\User::find($log->sender);
                                        $sender = isset($user)?$user->name:'';
                                        $receiver = $log->receiver;
                                        break;
                                    case 'approved':
                                        $panel = 'primary';
                                        $user = \App\User::find($log->sender);
                                        $sender = isset($user)?$user->name:'';
                                        $receiver = $log->receiver;
                                        break;
                                    case 'refunded':
                                        $panel = 'danger';
                                        $user = \App\User::find($log->receiver);
                                        $receiver = isset($user)?$user->name:'';
                                        $sender = $log->sender;
                                        break;
                                    default:
                                        $panel = 'default';
                                        $receiver = $log->receiver;
                                        $sender = $log->sender;
                                    break;
                                }

                                switch ($log->type) {
                                    case 'PlanLog':
                                        $currency = $basic->currency;
                                        $sender_text = 'Purchased By';
                                        $byy = Auth::user()->name;
                                        if ($log->status == 'refunded') {
                                            $sender_text = 'Refunded To';
                                            $byy = Auth::user()->name;
                                        }
                                        break;
                                    case 'PaymentLog':
                                        $currency = $basic->currency;
                                        $sender_text = 'Paid By';
                                        $payment = \App\PaymentLog::findOrFail($log->track);
                                        $byy = $payment->payment->name . ' Deposit';
                                        break;
                                    case 'UserData':
                                        $data = \App\UserData::find($log->track);
                                        $currency = isset($data)?$data->miner->code:'';
                                        break;
                                    case 'WithdrawLog':
                                        if ($log->status == 'requested') {
                                            $panel = 'warning';
                                        }
                                        $withdraw = \App\WithdrawLog::find($log->track);
                                        $data = \App\UserData::find($withdraw->method_id);
                                        $currency = isset($data)?$data->miner->code:'';
                                        $sender_text = 'Withdraw To';
                                        $byy = $basic->title.' System';
                                        if ($log->status == 'refunded') {
                                            $sender_text = 'Refunded To';
                                            $byy = Auth::user()->name;
                                        }
                                        break;
                                    case 'ReturnLog':
                                        /*if ($log->status == 'requested') {
                                            $panel = 'warning';
                                        }*/

                                        $return = \App\ReturnLog::findOrFail($log->track);

                                        $plan_log = \App\PlanLog::findOrFail($return->plan_log);

                                        $currency = @$plan_log->plan->category->code;
                                        $sender_text = 'Return Generated By';
                                        $byy = @$plan_log->plan->title . ' PLAN';
                                        break;
                                    default:
                                        $currency = $basic->currency;
                                    break;
                                }

                            @endphp

                            <div class="panel panel-{{ $panel }}">
                                <div class="panel-heading" role="tab" id="heading-{{ $log->id }}">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{ $log->id }}" aria-expanded="false" aria-controls="collapse-{{ $log->id }}">
                                            <div class="row">
                                                <div class="col-md-3" style="font-size: 20px;margin-top: 15px;">
                                                    {{ $log->created_at->format('d M') }}
                                                </div>
                                                <div class="col-md-6 text-center">
                                                    <h4>{{ $log->description }}</h4><span>{{ $sender_text }} {{ $byy }}</span>
                                                </div>
                                                <div class="col-md-3 text-right" style="font-size: 20px;margin-top: 15px;">
                                                    {{ $log->gross_amount }} {{ $currency }}
                                                </div>
                                            </div>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-{{ $log->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-{{ $log->id }}">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h3>{{ $sender_text }}</h3>
                                                <div>
                                                    <strong style="font-size: 16px;">{{ $byy }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <strong style="font-size: 20px;">Transaction ID</strong><br><br>
                                                <strong>{{ $log->trxid }}</strong><br><br>
                                                <div>
                                                    <i class="fa fa-calendar"></i>  {{ $log->created_at->format('d M, Y') }}
                                                    <i class="fa fa-clock-o"></i> {{ $log->created_at->format('h:m a') }}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <strong style="font-size: 20px;">Details</strong><br><br>
                                                <div style="margin-left: 10px;">
                                                    Gross Amount: {{ $log->gross_amount }} {{ $currency }}<br>
                                                    Charge: {{ $log->charge }} {{ $currency }}<br>
                                                    Net Amount: {{ $log->net_amount }} {{ $currency }}<br>
                                                </div>
                                            </div>
                                            @if(isset($log->custom) && !empty($log->custom))
                                                <br>
                                                <div class="col-md-12">
                                                    <strong style="font-size: 20px;">Message: </strong> {{ $log->custom }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    {{ $logs->links() }}
                                </div>
                            </div>
                    @else
                        <h1 class="text-center text-danger">Bạn không có bất kỳ nhật ký giao dịch nào. </h1>
                    @endif

                </div>

            </div>
        </div>
    
    </div>
</div>        
@endsection
