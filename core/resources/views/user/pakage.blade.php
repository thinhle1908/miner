@extends('layouts.user-frontend.user-dashboard')
@section('content')
    @include('layouts.breadcam')
    <section class="pricing-section section-padding">
        <div class="container">
            <!-- Pricing List Start -->
            @if($plan)
                @php $i = 0 @endphp
                @foreach($plan as $key => $package)
                    @php $i++ @endphp
                    @if($i%4 == 1)
                        <br>
                        <div class="row">
                            @endif
                            <div class="col-md-3 col-sm-6">
                                <!-- Pricing  List1 Start -->
                                <div class="pricing-list1 pricing-list2">
                                    <div class="pricing-thumb">
                                        <h3 class="text-center" style="color: #fff;padding-top: 20px;">{{ $package->miner }}</h3>
                                        <i class="fa fa-server" aria-hidden="true"></i>
                                    </div>
                                    <div class="pricing-header1">
                                        <h5>{{ $package->title }}</h5>
                                        <p>{{ $package->speed }}</p>
                                    </div>
                                    <div class="pricing-amount1"><p>{{ $basic->symbol }}</p><span> {{ $package->price }}</span></div>
                                    <div class="pricing-info1">
                                        <ul>
                                            @if(@unserialize($package->features))
                                                @foreach(@unserialize($package->features) as $feature)
                                                    <li>
                                                        <p>{{ $feature }}</p>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                    <a href="{{ route('miner', $key) }}">More Plan</a>
                                </div>
                                <!-- Pricing List1 End -->
                            </div>


                            @if($i%4 == 0)
                        </div>
                @endif
            @endforeach
        @endif
        <!-- Pricing List End -->


        </div>
    </section>
    <!-- Pricing Section End -->
    <div class="modal fade" id="lin">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title bold uppercase">Are You Sure To Purchase This Plan?</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text-center">Plan Price: <span id="pri">50</span> {{ $basic->currency }}</h4>
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <a href="" class="btn btn-primary btn-block bold uppercase" id="modl">Purchase</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('.buy').click(function (e) {
                e.preventDefault();
                var url = $(this).data('link');
                var price = $(this).data('price');
                $('#pri').text(price);
                $('#modl').attr('href', url);
                $('#lin').modal();
            });
        });
    </script>
@endsection