@extends('layouts.user-frontend.user-dashboard')
@section('content')
@include('layouts.breadcam')

<div class="content_padding">
    <div class="container user-dashboard-body">
   <div class="row">
            <div class="col-md-12">
            
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                         <div class="admin-header-text">  
                           <h3> Deposit history</h3>
                        </div>
                        
                    </div>    
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover" id="sample_1">

                        <thead>
                        <tr>
                            <th>ID#</th>
                            <th>Deposit Date</th>
                            <th>Transaction ID</th>
                            <th>Deposit Method</th>
                            <th>Send Amount</th>
                            <th>Deposit Charge</th>
                            <th>Deposit Balance</th>
                            <th>Status</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php $i=0;@endphp
                        @foreach($deposit as $p)
                            @php $i++;@endphp
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $p->created_at->format('d-F-Y h:i A') }}</td>
                                <td>{{ $p->transaction_id }}</td>
                                <td>{{ isset($p->method)?$p->method->name:'' }}</td>
                                <td>{{ $p->net_amount }} {{ $basic->currency }}</td>
                                <td>{{ $p->charge }} {{ $basic->currency }}</td>
                                <td>{{ $p->amount }} {{ $basic->currency }}</td>
                                <td>
                                    @if($p->status == 1)
                                        <span class="label bold label-primary"><i class="fa fa-check"></i> Completed</span>
                                    @elseif($p->status == 0)
                                        <span class="label bold label-warning"><i class="fa fa-spinner"></i> Pending</span>
                                    @elseif($p->status == 2)
                                        <span class="label bold label-danger"><i class="fa fa-times"></i> Cancel</span>
                                    @endif
                                </td>

                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  @endsection