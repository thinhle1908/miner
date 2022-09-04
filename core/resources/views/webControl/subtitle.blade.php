@extends('layouts.dashboard')

@section('style')

@endsection
@section('content')


    <div class="row">
        <div class="col-md-12">

            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <strong><i class="fa fa-info-circle"></i> {{ $page_title }}</strong>
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"> </a>
                    </div>
                </div>
                <div class="portlet-body">


                    {!! Form::model($page,['route'=>['update-subtitle',$page->id],'method'=>'put','role'=>'form','class'=>'form-horizontal','files'=>true]) !!}
                    <div class="form-body">

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">

                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Giới thiệu về Tiêu đề phụ</strong></label>
                                    <div class="col-md-12">
                                        <textarea name="about_subtitle" class="form-control input-lg" rows="3" placeholder="Giới thiệu về Tiêu đề phụ" required>{{ $page->about_subtitle }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Tiêu đề dịch vụ phụ</strong></label>
                                    <div class="col-md-12">
                                        <textarea name="service_subtitle" class="form-control input-lg" rows="3" placeholder="Tiêu đề dịch vụ phụ" required>{{ $page->service_subtitle }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Tiêu đề phụ của kế hoạch</strong></label>
                                    <div class="col-md-12">
                                        <textarea name="plan_subtitle" class="form-control input-lg" rows="3" placeholder="Tiêu đề phụ của kế hoạch" required>{{ $page->plan_subtitle }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-12"><strong style="text-transform: uppercase;">Chức danh phụ của nhà đầu tư</strong></label>
                                    <div class="col-md-12">
                                        <textarea name="investor_subtitle" class="form-control input-lg" rows="3" placeholder="Chức danh phụ của nhà đầu tư" required>{{ $page->investor_subtitle }}</textarea>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn blue btn-block bold btn-lg uppercase"><i class="fa fa-send"></i> Cập nhật</button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- row -->
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div><!---ROW-->


@endsection
@section('scripts')
    @if (session('alert'))

        <script type="text/javascript">

            $(document).ready(function(){

                swal("Sorry!", "{!! session('alert') !!}", "error");

            });

        </script>

    @endif
@endsection
