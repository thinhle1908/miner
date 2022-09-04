@extends('layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12">

      <div class="portlet light bordered">
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="depoist_request_table">

                        <thead>
                        <tr>
                            <th>ID#</th>
                            <th>Ngày</th>
                            <th>Mã giao dịch</th>
                            <th>Tên tài khoản</th>
                            <th>Trạng Thái</th>
                            <th>Số lượng</th>
                            <th style="text-align: center;">Hoạt động</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php $i=0;@endphp
                        @foreach($log as $p)
                            @php $i++;@endphp
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ date('d-F-Y h:i A',strtotime($p->created_at))  }}</td>
                                <td>{{ $p->custom }}</td>
                                <td>{{ $p->user->username }}</td>
                                <td>
                                    @if($p->status == 0)
                                        <span class="label bold label-warning"><i class="fa fa-spinner"></i> Đang Đợi</span>
                                    @elseif($p->status == 1)
                                        <span class="label bold label-success"><i class="fa fa-check-square-o"></i> Hoàn Thành</span>
                                    @elseif($p->status == 3)
                                        <span class="label bold label-danger"><i class="fa fa-times"></i> Hủy</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $p->amount }} - {{ $basic->currency }}
                                </td>
                                <td style="text-align: center;">
                                    @if($p->status == 0)
                                    <div class="btn-group btn-group-sm btn-group-solid">

                                    <button type="button" class="btn btn-sm delete_button" style="border-radius: 0px; background-color: #5cb85c; color:#fff" value="{{ $p->id }}" data-toggle="modal" href="#small" balance="{{$p->amount}}" status="1" user_id="{{$p->user->id}}">Chấp thuận</button>

                                     <button type="button" class="btn btn-sm red delete_button" style="border-radius: 0px" value="{{ $p->id }}" data-toggle="modal" href="#small" status="2">Hủy bỏ </button> </div>
                                    @else

                                    <a href="javascript:;" class="btn default blue-stripe"> <b> Không có sẵn </b></a>

                                    @endif
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


<!-- Modal Dialog -->
<div class="modal fade" id="small" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"> <b class="text-uppercase"> <span id="modal-heading">Yêu cầu tiền gửi Hủy bỏ</span> </b></h4>
      </div>
      <div class="modal-body">
        <h5> <b>Bạn có chắc về điều này ?</b></h5>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-danger btn-block" data-dismiss="modal" id="confirm_delete" style="color:#fff">Đúng</button>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="del_id">
<input type="hidden" id="balance">
<input type="hidden" id="status">
<input type="hidden" id="user_id">

@endsection
@section('scripts')
<script>

 $(document).ready(function() {

        $(document).on('click','.delete_button',function(){
    
                $("#del_id").val($(this).val());
                $("#balance").val($(this).attr('balance'))
                $("#status").val($(this).attr('status'));
                $("#user_id").val($(this).attr('user_id'));
                
                if($(this).attr('status')==1){
                    $('#modal-heading').text('Deposit Request Approve');
                    $('#confirm_delete').removeClass('btn-danger');
                    $('#confirm_delete').addClass('btn-success');
                }else{
                   $('#modal-heading').text('Deposit Request Cancel');
                   $('#confirm_delete').removeClass('btn-success');
                   $('#confirm_delete').addClass('btn-danger');
                }
           
          });   
                 
        $(document).on('click','#confirm_delete',function(){
              
            var id = $("#del_id").val();
            var amount = $("#balance").val(); 
            var status = $("#status").val(); 
            var uesr_id =  $("#user_id").val();
            var href = window.location.href.concat(' #depoist_request_table') ;    
            $.get("{{route('admin-payment-request-cancel')}}",{id,amount,status,uesr_id}, function(data){
              console.log(data);
                var href = window.location.href.concat(' #depoist_request_table') ;
                 $( "#depoist_request_table" ).load(href);
                 
                 if(status==1){
                    swal('Approve','Approve Successfully','success');
                 }else{
                    swal('Cancel','Cancel Successfully','error');
                 }
                 
            });  
        });
 });

</script>
@endsection
