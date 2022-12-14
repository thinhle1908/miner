@extends('layouts.user-frontend.user-dashboard')

@section('content')
@include('layouts.breadcam')

<div class="content_padding">
    <div class="container user-dashboard-body">
       <div class="row">
            <div class="col-md-12">
            
            <div class="panel panel-default">
              <div class="panel-heading panel-default-new"> 
                <div class="row">
                    <div class="col-md-6">
                        <div class="admin-header-text">  
                            <h3> Support Ticket Status</h3>
                        </div>
                    </div>
                    <div class="col-md-6"> <span class="pull-right"> <div class="admin-header-button support-btn">
                        <a href="{{ route('support-open') }}"><i class="fa fa-plus"></i> Open New Support Ticket</a>
                    </div> </span></div>
                </div>    
            </div>

              <div class="panel-body">
                  <table class="table table-striped table-bordered table-hover" id="sample_1">

                            <thead>
                            <tr>
                                <th>ID#</th>
                                <th>Ngày</th>
                                <th>Số Vé</th>
                                <th>Loại</th>
                                <th>Trạng Thái</th>
                                <th>Hoạt Động</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $i=0;@endphp
                            @foreach($support as $p)
                                @php $i++;@endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ \Carbon\Carbon::parse($p->created_at)->format('d F Y h:i A') }}</td>
                                    <td>{{ $p->ticket_number }}</td>
                                    <td>{{ $p->subject }}</td>
                                    <td>
                                        @if($p->status == 1)
                                            <span class="label bold label-info"><i class="fa fa-eye"></i> Mở</span>
                                        @elseif($p->status == 2)
                                            <span class="label bold label-success"><i class="fa fa-check"></i> Trả Lời</span>
                                        @elseif($p->status == 3)
                                            <span class="label bold label-warning"><i class="fa fa-mail-reply"></i> Trả lời của khách hàng</span>
                                        @elseif($p->status == 9)
                                            <span class="label bold label-danger"><i class="fa fa-times"></i> Đóng</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('support-message',$p->ticket_number) }}" class="btn btn-primary"><i class="fa fa-eye"></i> Xem</a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
              </div>
            </div>
            </div>
        </div><!-- ROW-->
    </div>
</div>
@endsection
@section('script')

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>


    @if (session('success'))

        <script type="text/javascript">

            $(document).ready(function(){

                swal("Success!", "{{ session('success') }}", "success");

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

