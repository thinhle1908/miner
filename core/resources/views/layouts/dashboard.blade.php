<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>{{ $site_title }} - {{ $page_title }}{{--{{ $site_title .' - '. $page_title }}--}}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    <!-- ASSETS -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('assets/admin/css/font-awesome.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('assets/admin/css/simple-line-icons.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/admin/css/uniform.default.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/admin/css/components-rounded.min.css')}}" rel="stylesheet" id="style_components"
          type="text/css"/>
    <link href="{{ asset('assets/admin/css/jquery.fileupload.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/admin/css/jquery.fileupload-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/css/plugins.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/admin/css/layout.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/admin/css/darkblue.min.css')}}" rel="stylesheet" type="text/css"
          id="style_color"/>
    <link href="{{asset('assets/admin/css/custom.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/admin/css/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/admin/css/datatables.bootstrap.css')}}"
          rel="stylesheet" type="text/css"/>
    <!-- END ASSETS -->

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/sweetalert.css') }}">

    <link rel="shortcut icon" href="{{asset('assets/images/icon.png')}}"/>


    <style>
        .page-title{
            font-weight:bold;
            text-transform: uppercase;
        }
        td,th{
            font-weight: bold;
        }
        .panel-body.no-side-padding{
            padding-left: 0;
            padding-right: 0;
        }
        .dashboard-stat .desc.small14, .small14{
            font-size: 14px;
        }
        .dashboard-stat .desc.small13, .small13{
            font-size: 13px;
        }
        .small12{
            font-size: 12px;
        }
    </style>
    @yield('style')

</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo">

    <!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <div class="page-header-inner ">


        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="{{--{{  }}--}}">
                <img src="{!! asset('assets/images/logo/logo.png') !!}" class="logo-default" alt="-"
                     style="filter: brightness(0) invert(1); width: 150px;height: 45px" />

            </a>

            <div class="menu-toggler sidebar-toggler"></div>
        </div>
        <!-- END LOGO -->


        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
           data-target=".navbar-collapse"> </a>

        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                       data-close-others="true">


                        <span class="username"> Ch??o m???ng, {!! Auth::guard('admin')->user()->name !!} </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">

                        <li><a href="{!! route('admin-change-password') !!}"><i class="fa fa-cogs"></i> Thay ?????i m???t kh???u</a>
                        </li>
                        <li><a href="{!! route('admin.logout') !!}"><i class="fa fa-sign-out"></i> ????ng xu???t </a></li>

                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- END HEADER -->


<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"></div>
<div class="page-container">
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">


            <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true"
                data-slide-speed="200" style="padding-top: 20px">
                <li class="sidebar-toggler-wrapper hide">
                    <div class="sidebar-toggler"></div>
                </li>


                <li class="nav-item start @if(request()->path() == 'admin-dashboard') active open @endif">
                    <a href="{!! route('dashboard') !!}" class="nav-link ">
                        <i class="icon-home"></i><span class="title">B???ng ??i???u Khi???n</span>
                    </a>
                </li>

                <li class="nav-item @if(request()->path() == 'admin/category') active open

                    @elseif(request()->path() == 'admin/add-plan') active open

                    @elseif(request()->path() == 'admin/plans') active open

                    @elseif(request()->path() == 'admin/plan-request') active open

                    @elseif(request()->path() == 'admin/plan-logs') active open

                @endif">
                    <a href="javascript:;" class="nav-link nav-toggle"><i class="fa fa-list"></i>
                        <span class="title">K??? Ho???ch Khai Th??c</span><span class="arrow"></span></a>
                    <ul class="sub-menu">
                        <li class="nav-item">
                            <a href="{!! route('category.index') !!}" class="nav-link nav-toggle"><i class="fa fa-desktop"></i>
                                <span class="title">Lo???i Ti???n</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('plan.addNew') !!}" class="nav-link nav-toggle"><i class="fa fa-plus"></i>
                                <span class="title">T???o K??? Ho???ch M???i</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('plan.index') !!}" class="nav-link nav-toggle"><i class="fa fa-desktop"></i>
                                <span class="title">Xem T???t C??? K??? Ho???ch</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('plan.request') !!}" class="nav-link nav-toggle"><i class="fa fa-desktop"></i>
                                <span class="title">Y??u C???u K??? Ho???ch</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('plan.logs') !!}" class="nav-link nav-toggle"><i class="fa fa-desktop"></i>
                                <span class="title">L???p L???ch Nh???t K??</span></a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item @if(request()->path() == 'admin/deposit-method') active open

                    @elseif(request()->path() == 'admin/deposit-history') active open

                @endif">
                    <a href="javascript:;" class="nav-link nav-toggle"><i class="fa fa-cloud-upload"></i>
                        <span class="title">Ti???n g???i</span><span class="arrow"></span></a>
                    <ul class="sub-menu">
                        <li class="nav-item">
                            <a href="{!! route('deposit-method')  !!}" class="nav-link nav-toggle"><i class="fa fa-desktop"></i>
                                <span class="title">Ph????ng th???c g???i ti???n</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('user-deposit-history')  !!}" class="nav-link nav-toggle"><i class="fa fa-list"></i>
                                <span class="title">Nh???t k?? ti???n g???i</span></a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item @if(request()->path() == 'admin/withdraw-confirm-show') active open

                    @elseif(request()->path() == 'admin/withdraw-pending') active open

                    @elseif(request()->path() == 'admin/withdraw-refund-show') active open

                    @elseif(request()->path() == 'admin/withdraw-request-all') active open

                @endif">
                    <a href="javascript:;" class="nav-link nav-toggle"><i class="fa fa-exchange"></i>
                        <span class="title">R??t</span><span class="arrow"></span></a>
                    <ul class="sub-menu">
                        <li class="nav-item">
                            <a href="{!! route('withdraw-confirm-show') !!}" class="nav-link nav-toggle"><i class="fa fa-check"></i>
                                <span class="title">R??t Ti???n ???? Ho??n Th??nh</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('withdraw-pending')  !!}" class="nav-link nav-toggle"><i class="fa fa-spinner"></i>
                                <span class="title">R??t Ti???n ??ang Ch??? X??? L??</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('withdraw-refund-show')  !!}" class="nav-link nav-toggle"><i class="fa fa-times"></i>
                                <span class="title">R??t Ti???n ???????c Ho??n L???i</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('withdraw-request-all')  !!}" class="nav-link nav-toggle"><i class="fa fa-cloud-upload"></i>
                                <span class="title">L???ch S??? R??t Ti???n</span></a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item @if(request()->path() == 'admin/manage-user') active open

                    @elseif(request()->path() == 'admin/show-block-user') active open

                    @elseif(request()->path() == 'admin/all-verify-user') active open

                    @elseif(request()->path() == 'admin/phone-unverified-user') active open

                    @elseif(request()->path() == 'admin/email-unverified-user') active open

                @endif">
                    <a href="javascript:;" class="nav-link nav-toggle"><i class="fa fa-users"></i>
                        <span class="title">Qu???n L?? Ng?????i D??ng</span><span class="arrow"></span></a>
                    <ul class="sub-menu">
                        <li class="nav-item">
                            <a href="{!! route('manage-user') !!}" class="nav-link nav-toggle"><i class="fa fa-desktop"></i>
                                <span class="title">T???t C??? Ng?????i D??ng</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('show-block-user') !!}" class="nav-link nav-toggle"><i class="fa fa-user-times"></i>
                                <span class="title">Ch???n Ng?????i D??ng</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('all-verify-user') !!}" class="nav-link nav-toggle"><i class="fa fa-check"></i>
                                <span class="title">Ng?????i D??ng ???? X??c Minh</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('phone-unverified-user') !!}" class="nav-link nav-toggle"><i class="fa fa-tty"></i>
                                <span class="title">S??? ??i???n Tho???i Ch??a X??c Minh</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('email-unverified-user') !!}" class="nav-link nav-toggle"><i class="fa fa-envelope-open"></i>
                                <span class="title">Email Ch??a X??c Minh</span></a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item @if(request()->path() == 'admin/admin-support') active open

                    @elseif(request()->path() == 'admin/admin-support-pending') active open

                @endif">
                    <a href="javascript:;" class="nav-link nav-toggle"><i class="fa fa-handshake-o"></i>
                        <span class="title">V?? ???ng H???</span><span class="arrow"></span></a>
                    <ul class="sub-menu">
                        <li class="nav-item">
                            <a href="{!! route('admin-support') !!}" class="nav-link nav-toggle"><i class="fa fa-desktop"></i>
                                <span class="title">T???t C??? V??</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('admin-support-pending') !!}" class="nav-link nav-toggle"><i class="fa fa-spinner"></i>
                                <span class="title">H??? Tr??? ??ang Ch??? X??? L??</span></a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item @if(request()->path() == 'admin/basic-setting') active open

                    @elseif(request()->path() == 'admin/contact-setting') active open

                    @elseif(request()->path() == 'admin/email-setting') active open

                    @elseif(request()->path() == 'admin/sms-setting') active open

                @endif">
                    <a href="javascript:;" class="nav-link nav-toggle"><i class="fa fa-desktop"></i>
                        <span class="title">??i???u Khi???n Web</span><span class="arrow"></span></a>
                    <ul class="sub-menu">
                        <li class="nav-item">
                            <a href="{!! route('basic-setting') !!}" class="nav-link nav-toggle"><i class="fa fa-cogs"></i>
                                <span class="title">Thi???t L???p C?? B???n</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('contact-setting') !!}" class="nav-link nav-toggle"><i class="fa fa-cogs"></i>
                                <span class="title">C??i ?????t Li??n H???</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('email-setting') !!}" class="nav-link"><i class="fa fa-cogs"></i>
                                C??i ?????t Email </a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('sms-setting') !!}" class="nav-link"><i class="fa fa-cogs"></i>
                                C??i ?????t SMS </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item @if(request()->path() == 'admin/manage-logo') active open

                    @elseif(request()->path() == 'admin/partner') active open

                    @elseif(request()->path() == 'admin/procedure') active open

                    @elseif(request()->path() == 'admin/manage-footer') active open

                    @elseif(request()->path() == 'admin/slider') active open

                    @elseif(request()->path() == 'admin/feature') active open

                    @elseif(request()->path() == 'admin/manage-subtitle') active open

                    @elseif(request()->path() == 'admin/manage-about-text') active open

                    @elseif(request()->path() == 'admin/manage-service') active open

                    @elseif(request()->path() == 'admin/manage-social') active open

                    @elseif(request()->path() == 'admin/menu-control') active open

                    @elseif(request()->path() == 'admin/manage-breadcrumb') active open

                    @elseif(request()->path() == 'admin/manage-about') active open

                    @elseif(request()->path() == 'admin/testimonial-create') active open

                    @elseif(request()->path() == 'admin/testimonial-all') active open

                    @elseif(request()->path() == 'admin/faqs-create') active open

                    @elseif(request()->path() == 'admin/faqs-all') active open

                @endif">
                    <a href="javascript:;" class="nav-link nav-toggle"><i class="fa fa-th"></i>
                        <span class="title">Ki???m So??t Giao Di???n</span><span class="arrow"></span></a>
                    <ul class="sub-menu">
                        <li class="nav-item">
                            <a href="{!! route('manage-logo') !!}" class="nav-link"><i class="fa fa-photo"></i>
                                Logo & Favicon</a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('tap') !!}" class="nav-link"><i class="fa fa-key"></i>
                                ??i???u Ki???n V?? Ch??nh S??ch</a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('partner.index') !!}" class="nav-link"><i class="fa fa-users"></i>
                                ?????i T??c</a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('procedure.index') !!}" class="nav-link"><i class="fa fa-sitemap"></i>
                                Tr??nh T??? C??ng Vi???c</a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('manage-footer') !!}" class="nav-link"><i class="fa fa-sitemap"></i>
                                Qu???n L?? Ch??n Trang</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('slider') }}" class="nav-link nav-toggle"><i class="fa fa-picture-o"></i>
                                <span class="title">Qu???n L?? Thanh Tr?????t</span></a>
                        </li>
                         <li class="nav-item">
                            <a href="{{ route('feature') }}" class="nav-link nav-toggle"><i class="fa fa-picture-o"></i>
                                <span class="title">Qu???n L?? T??nh N??ng</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('manage-subtitle') }}" class="nav-link nav-toggle"><i class="fa fa-file-text-o"></i>
                                <span class="title">Qu???n L?? Ph??? ?????</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('manage-about-text') }}" class="nav-link nav-toggle"><i class="fa fa-file-text-o"></i>
                                <span class="title">Qu???n L?? V??n B???n Gi???i Thi???u</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('manage-service') }}" class="nav-link nav-toggle"><i class="fa fa-th"></i>
                                <span class="title">Qu???n L?? D???ch V???</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('manage-social') }}" class="nav-link nav-toggle"><i class="fa fa-share-alt-square"></i>
                                <span class="title">Qu???n L?? M???ng X?? H???i</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('menu-control') !!}" class="nav-link"><i class="fa fa-desktop"></i>
                                ??i???u Khi???n Menu </a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('manage-breadcrumb') !!}" class="nav-link"><i class="fa fa-desktop"></i>
                                H??nh ???nh Breadcrumb</a>
                        </li>
                        <li class="nav-item">
                            <a href="{!! route('manage-about') !!}" class="nav-link"><i class="fa fa-address-card"></i>
                                Gi???i Thi???u Trang</a>
                        </li>
                        <li class="nav-item @if(request()->path() == 'admin/testimonial-create') active open

                    @elseif(request()->path() == 'admin/testimonial-all') active open @endif">
                            <a href="javascript:;" class="nav-link nav-toggle"><i class="fa fa-clone"></i>
                                <span class="title">Qu???n L?? L???i Ch???ng Th???c</span><span class="arrow"></span></a>
                            <ul class="sub-menu">
                                <li class="nav-item">
                                    <a href="{!! route('testimonial-create') !!}" class="nav-link"><i class="fa fa-plus"></i>
                                        L???i Ch???ng Th???c M???i</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{!! route('testimonial-all') !!}" class="nav-link"><i class="fa fa-desktop"></i>
                                        T???t C??? L???i Ch???ng Th???c</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item @if(request()->path() == 'admin/faqs-create') active open

                    @elseif(request()->path() == 'admin/faqs-all') active open

                @endif">
                            <a href="javascript:;" class="nav-link nav-toggle"><i class="fa fa-arrows"></i>
                                <span class="title">Qu???n L?? FAQS</span><span class="arrow"></span></a>
                            <ul class="sub-menu">
                                <li class="nav-item">
                                    <a href="{!! route('faqs-create') !!}" class="nav-link"><i class="fa fa-plus"></i>
                                        C??u H???i M???i</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{!! route('faqs-all') !!}" class="nav-link"><i class="fa fa-desktop"></i>
                                        T???t C??? C??u H???i</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>


            </ul>
            <!-- END SIDEBAR MENU -->
        </div>
    </div>
    <!-- END SIDEBAR -->


    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper" >
        <div class="page-content">
            <h3 class="page-title">{!! $page_title  !!} </h3>
            <hr>



            <!--  ==================================SESSION MESSAGES==================================  -->

            @yield('content')


        </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->


<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="page-footer-inner"> <?php echo date("Y")?> All Copyright &copy; Reserved. </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>
<!-- END FOOTER -->


<!-- BEGIN SCRIPTS -->
<script src="{{asset('assets/admin/js/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/bootstrap-hover-dropdown.min.js')}}"type="text/javascript"></script>
<script src="{{asset('assets/admin/js/jquery.slimscroll.min.js')}}"type="text/javascript"></script>
<script src="{{asset('assets/admin/js/jquery.blockui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/app.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/layout.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/demo.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/quick-sidebar.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/datatable.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/datatables.bootstrap.js')}}"type="text/javascript"></script>
<script src="{{asset('assets/admin/js/table-datatables-buttons.min.js')}}" type="text/javascript"></script>
 <!-- NicEditor -->
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">@yield('nic', 'bkLib.onDomLoaded(nicEditors.allTextAreas);')</script>

<script src="{{ asset('assets/admin/js/sweetalert.min.js') }}"></script>
<script>
    @if (session()->has('message'))
        swal({
            title: "{!! session()->get('title')  !!}",
            text: "{!! session()->get('message')  !!}",
            type: "{!! session()->get('type')  !!}",
            confirmButtonText: "OK"
        });
        @php session()->forget('message') @endphp
    @endif

</script>

<!--swal alert message-->
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
@if (session('error'))
    <script type="text/javascript">
        $(document).ready(function(){
            swal("Sorry!", "{{ session('error') }}", "error");
        });
    </script>
@endif


            <!--  ==================================VALIDATION ERRORS==================================  -->
            @if($errors->any())
                <script type="text/javascript">
                    swal('Error!', '{{ html_entity_decode(implode('\n', $errors->all())) }}', 'error');
                </script>
            @endif


<!--end swal alert message-->
@yield('scripts')


</body>
</html>