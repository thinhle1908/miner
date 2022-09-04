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
                           <h3> Withdraw history</h3>
                        </div>
                        
                    </div>    
                    <div class="panel-body">
  <table class="table table-striped table-bordered table-hover" id="sample_1">

                        <thead>
                        <tr>
                            <th>Ngày</th>
                            <th>ID giao dịch</th>
                            <th>Đồng xu / Phương thức</th>
                            <th>Rút tiền</th>
                            <th>Trạng thái</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php $i=0;@endphp
                        @foreach($log as $p)
                            @php $i++;@endphp
                            <tr>
                                <td>{{ $p->created_at->format('d M Y')  }}</td>
                                <td>{{ $p->transaction_id }}</td>
                                <td>
                                    @if($p->type == 'general')
                                        @php
                                            $currency = $basic->currency;
                                        @endphp
                                        {{ $p->method->name }}
                                    @elseif($p->type == 'coin')
                                        @php
                                            $data = \App\UserData::find($p->method_id);
                                            $currency = isset($data)?$data->miner->code:'';
                                        @endphp
                                        {{ $data->miner->code }}
                                    @endif
                                </td>
                                <td>{{ $p->amount }} - {{ $currency }}</td>
                                <td>
                                    @if($p->status == 0 )
                                        <span class="label bold label-warning"><i class="fa fa-spinner"></i> Chưa giải quyết</span>
                                    @elseif($p->status == 1)
                                        <span class="label bold label-success"><i class="fa fa-check"></i> Hoàn thành</span>
                                    @elseif($p->status == 2)
                                        <span class="label bold label-danger"><i class="fa fa-times"></i> Đền bù</span>
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

@section('script')
    <script src="{{ asset('assets/admin/js/bootstrap-fileinput.js') }}"></script>

    @if (session('message'))

        <script type="text/javascript">

            $(document).ready(function(){

                swal("Success!", "{{ session('message') }}", "success");

            });

        </script>

    @endif



    @if (session('alert'))

        <script type="text/javascript">

            $(document).ready(function(){

                swal("Sorry!", "{{ session('alert') }}", "error");

            });

        </script>

    @endif
@endsection

