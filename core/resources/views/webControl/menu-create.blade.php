@extends('layouts.dashboard')
@section('style')
    <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script>

    <script type="text/javascript">
        bkLib.onDomLoaded(function() { new nicEditor({fullPanel : true}).panelInstance('area1'); });
    </script>

@endsection

@section('content')


    <div class="row">
        <div class="col-md-12">

            <div class="portlet light bordered">
                <div class="portlet-body form">
                    <form class="form-horizontal" action="{{ route('menu-create') }}" method="post" role="form">

                        {!! csrf_field() !!}
                        <div class="form-body">

                            <div class="form-group">
                                <label class="col-md-12"><strong style="text-transform: uppercase;">Tên thực đơn</strong></label>
                                <div class="col-md-12">
                                    <input class="form-control input-lg" name="name" placeholder="" type="text" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"><strong style="text-transform: uppercase;">NỘI DUNG</strong></label>
                                <div class="col-md-12">
                                    <textarea id="area1" class="form-control" rows="15" name="description"></textarea>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn blue btn-block btn-lg"><i class="fa fa-plus"></i> THÊM THỰC ĐƠN</button>
                                </div>
                            </div>

                        </div>
                    </form>

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