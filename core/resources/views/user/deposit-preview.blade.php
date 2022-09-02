@extends('layouts.user-frontend.user-dashboard')
@section('style')
    <style>
        .input-text-box input{
            border: 1px solid #CCCCCC;
        }
    </style>
@endsection
@section('content')
@include('layouts.breadcam')
<div class="content_padding">
    <div class="container user-dashboard-body">

        @if($fund)
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default panel-shadow" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title"><i class="fa fa-desktop"></i><strong> {{ $page_title }}</strong></div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="margin-top: 5px;font-size: 14px;" class="col-md-6 text-right control-label"><strong>Deposit Amount : </strong></label>

                                        <div class="col-md-6">
                                            <div class="input-group input-text-box">
                                                <input type="text" value="{{ $fund->amount }}" readonly name="amount" id="amount" class="form-control bold" placeholder="Enter Deposit Amount" required>
                                                <span class="input-group-addon red">&nbsp;<strong>{{ $basic->currency }} </strong></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="margin-top: 5px;font-size: 14px;" class="col-md-6 text-right control-label"><strong>Charge : </strong></label>

                                        <div class="col-md-6">
                                            <div class="input-group input-text-box">
                                                <input type="text" value="{{ $fund->charge }}" readonly name="charge" id="charge" class="form-control bold" placeholder="Enter Deposit Amount" required>
                                                <span class="input-group-addon red">&nbsp;<strong> {{ $basic->currency }} </strong></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="margin-top: 5px;font-size: 14px;" class="col-md-6 text-right control-label"><strong>Total Send : </strong></label>

                                        <div class="col-md-6">
                                            <div class="input-group input-text-box">
                                                <input type="text" value="{{ $fund->amount + $fund->charge }}" readonly name="" id="" class="form-control bold" placeholder="Enter Deposit Amount" required>
                                                <span class="input-group-addon red">&nbsp;<strong> {{ $basic->currency }} </strong></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="margin-top: 5px;font-size: 14px;" class="col-md-6 text-right control-label"><strong>Conversion Rate : </strong></label>

                                        <div class="col-md-6">
                                            <div class="input-group input-text-box">
                                                <input type="text" value="1 USD = {{ $fund->payment->rate }}" readonly name="charge" id="charge" class="form-control bold" placeholder="Enter Deposit Amount" required>
                                                <span class="input-group-addon red">&nbsp;<strong> {{ $basic->currency }} </strong></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="margin-top: 5px;font-size: 14px;" class="col-md-6 text-right control-label"><strong>Total Amount : </strong></label>

                                        <div class="col-md-6">
                                            <div class="input-group input-text-box">
                                                <input type="text" value="{{ round($fund->net_amount, $basic->deci)  }}" readonly name="charge" id="charge" class="form-control bold" placeholder="Enter Deposit Amount" required>
                                                <span class="input-group-addon red">&nbsp;<strong> {{ $basic->currency }} </strong></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="{{ route('deposit-fund') }}" class="btn btn-primary btn-block btn-icon icon-left btn-own">
                                        Back to Payment Method Page
                                    </a>
                                </div>
                                <div class="col-sm-6">
                                    <a class="btn btn-success btn-block bold btn-icon icon-left btn-own" href="{{ route('deposit', $fund->custom) }}">
                                        Add Fund Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection

@section('script')
    @if (session('message'))

        <script type="text/javascript">

            $(document).ready(function(){

                swal("{{ (session('title') != NULL)?session('title'):'Success!' }}", "{{ session('message') }}", "{{ (session('type') != NULL)?session('type'):'success' }}");

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
