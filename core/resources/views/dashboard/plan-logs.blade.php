@extends('layouts.dashboard')

@section('content')


    <div class="row">
        <div class="col-md-12">

            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption uppercase">
                        <strong><i class="fa fa-info-circle"></i> {{ $page_title }}</strong>
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                        <tr>
                            <th> ID </th>
                            <th> Tài Khoản </th>
                            <th> Kế Hoạch </th>
                            <th> Loại Tiền </th>
                            <th> Trạng Thái </th>
                        </tr>
                        </thead>
                        <tbody>

                        @if($logs)

                            @foreach($logs as $log)

                                <tr>
                                    <td> {{ $log->id }} </td>
                                    <td><a href="{{ route('plan.logs.user', $log->user->id) }}" title="All Purchased Plan">{{ $log->user->name }}</a> </td>
                                    <td> {{ $log->plan->title }} </td>
                                    <td> {{ $log->plan->category->name }} </td>
                                    <td>
                                        @if($log->status == 0)
                                            <a href="{{ route('approve-plan', $log->id) }}" class="btn btn-success btn-sm" role="button">
                                                Approve
                                            </a>
                                            <button class="btn btn-warning dltbtn btn-sm" item="{{ $log->id }}" role="button">
                                                Refund
                                            </button>
                                        @elseif($log->status == 1)
                                            <b class="text-center text-success">Approved</b>
                                        @elseif($log->status == 2)
                                            <b class="text-center text-danger">Refunded</b>
                                        @elseif($log->status == -10)
                                            <b class="text-center text-danger">Expaired</b>
                                        @endif
                                    </td>
                                </tr>

                            @endforeach

                            <tr>
                                <td colspan="5" class="text-right">
                                    {{ $logs->links() }}
                                </td>
                            </tr>

                        @endif

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    <!-- Modal -->
    <div id="dltmodel" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Refund Request</h4>
                </div>
                <form id="dltform" method="post">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p><strong>Are You Sure To Refund?</strong></p>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="" class="control-label"><strong>Custom Message: </strong></label>
                            </div>

                            <div class="col-md-12">
                                <textarea name="msg" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Refund</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection

@section('nic', 'shanto')

@section('scripts')
    <script>
        (function ($) {
            $(document).ready(function () {
                $('.dltbtn').click(function (e) {
                    var id = $(this).attr('item');
                    var url = '{{ url('admin/refund-plan-request') }}/' + id;
                    $('#dltform').attr('action', url);
                    $('#dltmodel').modal();
                });
            });
        })(jQuery);
    </script>
@endsection