@extends('layouts.user-frontend.user-dashboard')

@section('content')
    
@include('layouts.breadcam')

<div class="content_padding">
    <div class="container user-dashboard-body">

        <div class="row">

            @if($coins && count($coins))

                @foreach($coins as $coin)

                        <div class="col-sm-4 text-center">
                            <div class="panel panel-green panel-pricing">
                                <div class="panel-heading">
                                    <h3 style="font-size: 28px; color: #ffffff"><b>{{ $coin->miner->code }} Rút</b></h3>
                                </div>
                                <ul style='font-size: 15px;' class="list-group text-center bold">
                                    <li class="list-group-item">Cái ví - <b>{!! $coin->wallet !!}</b> </li>
                                    <li class="list-group-item">Số dư Hiện tại- <b>{!! $coin->balance !!}</b> {{ $coin->miner->code }} </li>
                                    <li class="list-group-item">Thay đổi - {{ $basic->withdraw_charge }}% </li>
                                </ul>
                                <div class="panel-footer" style="overflow: hidden">
                                    <div class="col-sm-12">
                                        <a href="#" @if($basic->withdraw_status == 0) disabled @endif class="btn btn-primary btn-block bold btn-own withc" data-code="{{ $coin->miner->code }}" data-id="{{ $coin->id }}"> Rút tiền ngay</a>
                                    </div>

                                </div>
                            </div>
                        </div>

                @endforeach
            @else
                <h1 class="text-danger text-center">Bạn không có số dư tiền xu để rút tiền</h1>
            @endif

        </div>


        <div class="modal fade" id="withd">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><strong>Rút tiền qua <span id="edit_name"></span></strong> </h4>
                    </div>
                    <form method="post" action="{{ route('withdraw', 'general') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="method_id" id="edit_id" value="">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <span style="margin-bottom: 10px;"><code>Rút tiền phí : (<span id="edit_fix"></span> {{ $basic->currency }} + <span id="edit_percent"></span>%)</code></span>
                                            <div class="input-group" style="margin-top: 10px;margin-bottom: 10px;">
                                                <input type="text" value="" id="amount" name="amount" class="form-control" required placeholder="Amount" />
                                                <span class="input-group-addon">&nbsp;<strong>{{ $basic->currency }}</strong></span>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-primary btn-block btn-own">Rút tiền ngay</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="withc">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><strong><span id="edit_cname"></span> Rút</strong> </h4>
                    </div>
                    <form method="post" action="{{ route('withdraw', 'coin') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="miner_id" id="edit_cid" value="">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <span style="margin-bottom: 10px;"><code>Rút tiền phí : {{ $basic->withdraw_charge }}%</code></span>
                                            <div class="input-group" style="margin-top: 10px;margin-bottom: 10px;">
                                                <input type="text" value="" id="amount" name="amount" class="form-control" required placeholder="Amount" />
                                                <span class="input-group-addon">&nbsp;<strong><span id="ccurrency"></span></strong></span>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-primary btn-block btn-own">Rút tiền ngay</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection

@section('script')

    @if (session('message'))

        <script type="text/javascript">

            $(document).ready(function(){

                swal("{{ session('title') }}", "{{ session('message') }}", "{{ session('type') }}");

            });

        </script>

    @endif

    @if (session('alert'))

        <script type="text/javascript">

            $(document).ready(function(){

                swal("Sorry!", "{!! session('alert') !!}", "error");

            });

        </script>

    @endif

    <script>
        (function ($) {
            $(document).ready(function(){

                $('.withb').click(function (e) {

                    e.preventDefault();

                    var id = $(this).data('id');
                    var name = $(this).data('name');
                    var fix = $(this).data('fix');
                    var percent = $(this).data('percent');

                    $('#edit_id').val(id);
                    $('#edit_name').text(name);
                    $('#edit_fix').text(fix);
                    $('#edit_percent').text(percent);

                    $('#withd').modal();
                });

                $('.withc').click(function (e) {
                    e.preventDefault();
                    var code = $(this).data('code');
                    var id = $(this).data('id');

                    $('#edit_cname').text(code);
                    $('#edit_cid').val(id);
                    $('#ccurrency').text(code);

                    $('#withc').modal();
                });

            });
        })(jQuery);
    </script>
@endsection