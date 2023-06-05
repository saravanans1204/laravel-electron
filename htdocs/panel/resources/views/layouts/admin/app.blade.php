<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <!-- Title -->
    <title>@yield('title')</title>
    <!-- Favicon -->
    @php($logo=\App\Models\BusinessSetting::where(['key'=>'icon'])->first()->value)
    <link rel="shortcut icon" href="">
    <link rel="icon" type="image/x-icon" href="{{asset('storage/app/public/business/'.$logo??'')}}">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&amp;display=swap" rel="stylesheet">
    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{asset('public/assets/admin/css/vendor.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/admin/vendor/icon-set/style.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/admin/css/custom.css')}}">
    <!-- CSS Front Template -->
    <link rel="stylesheet" href="{{asset('public/assets/admin/css/theme.minc619.css?v=1.0')}}">
    @stack('css_or_js')

    <style>
        :root {
            --theameColor: #045cff;
        }
        .scroll-bar {
            max-height: calc(100vh - 100px);
            overflow-y: auto !important;
        }

        ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 1px #cfcfcf;
            /*border-radius: 5px;*/
        }

        ::-webkit-scrollbar {
            width: 3px!important;
            height: 3px!important;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            /*border-radius: 5px;*/
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #003638;
        }

        @media only screen and (max-width: 768px) {
            /* For mobile phones: */
            .map-warper {
                height: 250px;
                padding-bottom: 10px;
            }
        }
        .deco-none {
            color: inherit;
            text-decoration: inherit;
        }
        .qcont {
            text-transform: lowercase;
        }
        .qcont:first-letter {
            text-transform: capitalize;
        }

        /* .navbar-vertical .nav-link {
            color: #ffffff !important;
        }

        .navbar .active > .nav-link, .navbar .nav-link.active, .navbar .nav-link.show, .navbar .show > .nav-link {
            color: #C6FFC1 !important;
        } */



        .navbar-vertical .nav-link {
            color: #E5E5E5;
        }

        .navbar .nav-link:hover {
            color: #C6FFC1;
        }

        .navbar .active > .nav-link, .navbar .nav-link.active, .navbar .nav-link.show, .navbar .show > .nav-link {
            color: #C6FFC1;
        }

        .navbar-vertical .active .nav-indicator-icon, .navbar-vertical .nav-link:hover .nav-indicator-icon, .navbar-vertical .show > .nav-link > .nav-indicator-icon {
            color: #C6FFC1;
        }

        .nav-subtitle {
            display: block;
            color: #6D8C7E;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .03125rem;
        }

        .navbar-vertical .navbar-nav.nav-tabs .active .nav-link, .navbar-vertical .navbar-nav.nav-tabs .active.nav-link {
            border-left-color: #C6FFC1;
        }

        .cursor-pointer{
            cursor: pointer;
        }

        .floating-menu{
            border-radius:100px;
            z-index:999;
            padding-top:10px;
            padding-bottom:10px;
            right:0;
            position:fixed;
            display:inline-block;
            top:50%;
            -webkit-transform:translateY(-50%);
            -ms-transform:translateY(-50%);
            transform:translateY(-50%);
        }
        .main-menu{
            margin:0;
            padding-left:0;
            list-style:none;
        }
        .main-menu li a:hover{
            background:rgba(244,244,244,.3);
        }
        .menu-bg{
            /* background-image:-webkit-linear-gradient(top,#1C5E91 0,#167699 100%);
            background-image:-o-linear-gradient(top,#1C5E91 0,#167699 100%);
            background-image:-webkit-gradient(linear,left top,left bottom,from(#1C5E91),to(#167699));
            background-image:linear-gradient(to bottom,#1C5E91 0,#167699 100%);
            background-repeat:repeat-x; */
            background-color: #334257;
            position:absolute;
            width:100%;height:100%;
            border-radius:50px;z-index:-1;
            top:0;
            left:0;
            -webkit-transition:.1s;
            -o-transition:.1s;
            transition:.1s;
        }
        .ripple{
            position:relative;
            overflow:hidden;
            transform:translate3d(0,0,0);
        }
        .ripple:after{
            content:"";
            display:block;
            position:absolute;
            width:100%;
            height:100%;
            top:0;
            left:0;
            pointer-events:none;
            background-image:radial-gradient(circle,#000 10%,transparent 10.01%);
            background-repeat:no-repeat;
            background-position:50%;
            transform:scale(10,10);
            opacity:0;
            transition:transform .5s,opacity 1s;
        }
        .ripple:active:after{
            transform:scale(0,0);
            opacity:.2;
            transition:0s;
        }
    </style>

    <script
        src="{{asset('public/assets/admin')}}/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside-mini-cache.js"></script>
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/toastr.css">
</head>

<body class="footer-offset">

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="loading" style="display: none;">
                <div style="position: fixed;z-index: 9999; left: 40%;top: 37% ;width: 100%">
                    <img width="200" src="{{asset('public/assets/admin/img/loader.gif')}}">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Builder -->
@include('layouts.admin.partials._front-settings')
<!-- End Builder -->

<!-- JS Preview mode only -->
@include('layouts.admin.partials._header')
@include('layouts.admin.partials._sidebar')
<!-- END ONLY DEV -->

<main id="content" role="main" class="main pointer-event">
    <!-- Content -->
@yield('content')
<!-- End Content -->

    <!-- Footer -->
@include('layouts.admin.partials._footer')
<!-- End Footer -->

    <div class="modal fade" id="popup-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <center>
                                <h2 style="color: rgba(96,96,96,0.68)">
                                    <i class="tio-shopping-cart-outlined"></i> {{translate('messages.You have new order, Check Please.')}}
                                </h2>
                                <hr>
                                <button onclick="check_order()" class="btn btn-primary">{{translate('messages.Ok, let me check')}}</button>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
{{--<nav class="floating-menu">
    <ul class="main-menu">
        @foreach (\App\Models\Module::notParcel()->get() as $module)
        <li>
            <a class="p-2 navbar-dropdown-account-wrapper" href="javascript:;" onclick="set_filter('{{url()->full()}}',{{$module->id}},'module_id')" title="{{$module->module_name}}">
                <img class="avatar avatar-sm avatar-circle" src="{{asset('storage/app/public/module')}}/{{$module['thumbnail']}}" alt="{{$module->module_name}}" width="20">
            </a>
        </li>
        @endforeach
        <li>
            <a class="p-2 navbar-dropdown-account-wrapper" href="javascript:;" onclick="set_filter('{{url()->full()}}','','module_id')" title="{{$module->module_name}}">
                <img class="avatar avatar-sm avatar-circle" src="{{asset('storage/app/public/business/'.$logo??'')}}" alt="{{translate('messages.all')}} {{translate('messages.module')}}" width="20">
            </a>
        </li>
    </ul>
    <div class="menu-bg"></div>
</nav>--}}
<!-- ========== END MAIN CONTENT ========== -->

<!-- ========== END SECONDARY CONTENTS ========== -->
<script src="{{asset('public/assets/admin')}}/js/custom.js"></script>
<!-- JS Implementing Plugins -->

@stack('script')
<!-- JS Front -->
<script src="{{asset('public/assets/admin')}}/js/vendor.min.js"></script>
<script src="{{asset('public/assets/admin')}}/js/theme.min.js"></script>
<script src="{{asset('public/assets/admin')}}/js/sweet_alert.js"></script>
<script src="{{asset('public/assets/admin')}}/js/toastr.js"></script>
{!! Toastr::message() !!}

@if ($errors->any())
    <script>
        @foreach($errors->all() as $error)
        toastr.error('{{$error}}', Error, {
            CloseButton: true,
            ProgressBar: true
        });
        @endforeach
    </script>
@endif
<!-- JS Plugins Init. -->
<script>
    $(document).on('ready', function () {
        // ONLY DEV
        // =======================================================
        if (window.localStorage.getItem('hs-builder-popover') === null) {
            $('#builderPopover').popover('show')
                .on('shown.bs.popover', function () {
                    $('.popover').last().addClass('popover-dark')
                });

            $(document).on('click', '#closeBuilderPopover', function () {
                window.localStorage.setItem('hs-builder-popover', true);
                $('#builderPopover').popover('dispose');
            });
        } else {
            $('#builderPopover').on('show.bs.popover', function () {
                return false
            });
        }
        // END ONLY DEV
        // =======================================================

        // BUILDER TOGGLE INVOKER
        // =======================================================
        $('.js-navbar-vertical-aside-toggle-invoker').click(function () {
            $('.js-navbar-vertical-aside-toggle-invoker i').tooltip('hide');
        });

        // INITIALIZATION OF NAVBAR VERTICAL NAVIGATION
        // =======================================================
        var sidebar = $('.js-navbar-vertical-aside').hsSideNav();


        // INITIALIZATION OF TOOLTIP IN NAVBAR VERTICAL MENU
        // =======================================================
        $('.js-nav-tooltip-link').tooltip({boundary: 'window'})

        $(".js-nav-tooltip-link").on("show.bs.tooltip", function (e) {
            if (!$("body").hasClass("navbar-vertical-aside-mini-mode")) {
                return false;
            }
        });


        // INITIALIZATION OF UNFOLD
        // =======================================================
        $('.js-hs-unfold-invoker').each(function () {
            var unfold = new HSUnfold($(this)).init();
        });


        // INITIALIZATION OF FORM SEARCH
        // =======================================================
        $('.js-form-search').each(function () {
            new HSFormSearch($(this)).init()
        });


        // INITIALIZATION OF SELECT2
        // =======================================================
        $('.js-select2-custom').each(function () {
            var select2 = $.HSCore.components.HSSelect2.init($(this));
        });


        // INITIALIZATION OF DATERANGEPICKER
        // =======================================================
        $('.js-daterangepicker').daterangepicker();

        $('.js-daterangepicker-times').daterangepicker({
            timePicker: true,
            startDate: moment().startOf('hour'),
            endDate: moment().startOf('hour').add(32, 'hour'),
            locale: {
                format: 'M/DD hh:mm A'
            }
        });

        var start = moment();
        var end = moment();

        function cb(start, end) {
            $('#js-daterangepicker-predefined .js-daterangepicker-predefined-preview').html(start.format('MMM D') + ' - ' + end.format('MMM D, YYYY'));
        }

        $('#js-daterangepicker-predefined').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);


        // INITIALIZATION OF CLIPBOARD
        // =======================================================
        $('.js-clipboard').each(function () {
            var clipboard = $.HSCore.components.HSClipboard.init(this);
        });
    });
</script>

@stack('script_2')
<audio id="myAudio">
    <source src="{{asset('public/assets/admin/sound/notification.mp3')}}" type="audio/mpeg">
</audio>

<script>
    var audio = document.getElementById("myAudio");

    function playAudio() {
        audio.play();
    }

    function pauseAudio() {
        audio.pause();
    }
</script>
<script>
    var new_order_type='store_order';
    @if(\App\CentralLogics\Helpers::module_permission_check('order'))
        @php($admin_order_notification=\App\Models\BusinessSetting::where('key','admin_order_notification')->first())
        @php($admin_order_notification=$admin_order_notification?$admin_order_notification->value:0)
        @if($admin_order_notification)
        setInterval(function () {
            $.get({
                url: '{{route('admin.get-store-data')}}',
                dataType: 'json',
                success: function (response) {
                    let data = response.data;
                    new_order_type = data.type;
                    if (data.new_order > 0) {
                        playAudio();
                        $('#popup-modal').appendTo("body").modal('show');
                    }
                },
            });
        }, 10000);

        function check_order() {
            if(new_order_type == 'parcel_order')
            {
                location.href = "{{route('admin.parcel.orders')}}";
            }
            else
            {
                location.href = "{{route('admin.order.list',['status'=>'all'])}}";
            }
            
        }
        @endif
    @endif
    function route_alert(route, message, title="{{translate('messages.are_you_sure')}}") {
        Swal.fire({
            title: title,
            text: message,
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: 'default',
            confirmButtonColor: '#FC6A57',
            cancelButtonText: 'No',
            confirmButtonText: 'Yes',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                location.href = route;
            }
        })
    }

    function form_alert(id, message) {
        Swal.fire({
            title: 'Are you sure?',
            text: message,
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: 'default',
            confirmButtonColor: '#FC6A57',
            cancelButtonText: 'No',
            confirmButtonText: 'Yes',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $('#'+id).submit()
            }
        })
    }
    function set_zone_filter(url, id) {
        var nurl = new URL(url);
        nurl.searchParams.set('zone_id', id);

        location.href = nurl;
    }
    
    function set_store_filter(url, id) {
        var nurl = new URL(url);
        nurl.searchParams.set('store_id', id);
        location.href = nurl;
    }

    function set_filter(url, id, filter_by) {
        var nurl = new URL(url);
        nurl.searchParams.set(filter_by, id);
        location.href = nurl;
    }

    function copy_text(copyText) {
        /* Copy the text inside the text field */
        navigator.clipboard.writeText(copyText);

        toastr.success('{{translate('messages.text_copied')}}', {
            CloseButton: true,
            ProgressBar: true
        });
    }
</script>

<script>
    function call_demo(){
        toastr.info('Update option is disabled for demo!', {
            CloseButton: true,
            ProgressBar: true
        });
    }
</script>

<!-- IE Support -->
<script>
    if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="{{asset('public/assets/admin')}}/vendor/babel-polyfill/polyfill.min.js"><\/script>');
</script>
</body>
</html>
