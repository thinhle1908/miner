@extends('layouts.user-frontend.user-dashboard')
@section('content')
@include('layouts.breadcam')

<div class="content_padding">
    <div class="container user-dashboard-body">
        @if($methods)
            <div class="row">
            @foreach($methods as $method)
                <div class="col-md-3">
                    <div class="panel panel-default" data-collapsed="0">
                        <!-- panel head -->
                        <div class="panel-heading">
                            <div class="panel-title"><strong>{{ $method->name }}</strong></div>

                        </div>
                        <!-- panel body -->
                        <div class="panel-body">
                            <img width="100%" class="image-responsive" src="{{ asset('assets/images') }}/{{ $method->image }}" alt="{{ $method->name }}">
                        </div>
                        <div class="panel-footer">
                            <a href="#" class="btn btn-primary btn-block btn-icon icon-lef bold uppercaset toggle btn-own" data-name="{{ $method->name }}" data-type="{{ $method->id }}" data-fix="{{ $method->fix }}" data-per="{{ $method->percent }}">THÊM QUỸ</a>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        @endif
    </div>
</div>

<div class="modal fade" id="modd">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title bold uppercase">Add Fund via <span id="m-name"></span></h4>
            </div>
            {{ Form::open() }}
            <input type="hidden" name="payment_type" id="m-type" value="">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <span style="margin-bottom: 10px;"><code>Deposit Charge : (<span id="m-fix"></span> {{ $basic->currency }} + <span id="m-per"></span> %)</code></span>
                        <div class="input-group" style="margin-top: 10px;margin-bottom: 10px;">
                                <input type="text" value="" id="amount" name="amount" class="form-control" required placeholder="Amount"/>
                                <span class="input-group-addon">&nbsp;<strong>{{ $basic->currency }}</strong></span>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button class="btn btn-primary btn-block bold uppercase btn-own">Add Fund</button>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
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

                swal("Sorry!", "{{ session('alert') }}", "error");

            });

        </script>

    @endif

    <script>
        (function ($) {
            $(document).ready(function () {
                $('.toggle').click(function (e) {
                    e.preventDefault();
                    var name = $(this).data('name');
                    var type = $(this).data('type');
                    var fix = $(this).data('fix');
                    var per = $(this).data('per');

                    $('#m-name').text(name);
                    $('#m-type').val(type);
                    $('#m-fix').text(fix);
                    $('#m-per').text(per);

                    $('#modd').modal();
                });
            });
        })(jQuery);
    </script>
@endsection
