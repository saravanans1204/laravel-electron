@extends('layouts.admin.app')

@section('title',$store->name)

@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/admin/css/croppie.css')}}" rel="stylesheet">
    <style>
        .flex-item{
            padding: 10px;
            flex: 20%;
        }

        /* Responsive layout - makes a one column-layout instead of a two-column layout */
        @media (max-width: 768px) {
            .flex-item{
                flex: 50%;
            }
        }

        @media (max-width: 480px) {
            .flex-item{
                flex: 100%;
            }
        }
    </style>
@endpush

@section('content')
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{translate('messages.dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{translate('messages.vendor_view')}}</li>
        </ol>
    </nav>

    @include('admin-views.vendor.view.partials._header',['store'=>$store])
    <div class="card">
        <div class="card-body" style="padding: 0">
            <!-- Nav -->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link text-capitalize {{$sub_tab=='cash'?'active':''}}" href="{{route('admin.vendor.view', ['store'=>$store->id, 'tab'=> 'transaction', 'sub_tab'=>'cash'])}}"  aria-disabled="true">{{translate('messages.cash')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-capitalize {{$sub_tab=='digital'?'active':''}}" href="{{route('admin.vendor.view', ['store'=>$store->id, 'tab'=> 'transaction', 'sub_tab'=>'digital'])}}"  aria-disabled="true">{{translate('messages.order')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-capitalize {{$sub_tab=='withdraw'?'active':''}}" href="{{route('admin.vendor.view', ['store'=>$store->id, 'tab'=> 'transaction', 'sub_tab'=>'withdraw'])}}"  aria-disabled="true">{{translate('messages.withdraw')}}</a>
                </li>
            </ul>
            <!-- End Nav -->

        @if($sub_tab=='cash')
            @include('admin-views.vendor.view.partials.cash_transaction')
        @elseif ($sub_tab=='digital')
            @include('admin-views.vendor.view.partials.digital_transaction')
        @elseif ($sub_tab=='withdraw')
            @include('admin-views.vendor.view.partials.withdraw_transaction')
        @endif
        
    </div>
</div>
@endsection

@push('script_2')
    <!-- Page level plugins -->
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{\App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value}}&callback=initMap&v=3.45.8" ></script>
    <script>
        const myLatLng = { lat: {{$store->latitude}}, lng: {{$store->longitude}} };
        let map;
        initMap();
        function initMap() {
                 map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: myLatLng,
            });
            new google.maps.Marker({
                position: myLatLng,
                map,
                title: "{{$store->name}}",
            });
        }
    </script>
    <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function () {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });

            $('#column2_search').on('keyup', function () {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });

            $('#column3_search').on('change', function () {
                datatable
                    .columns(3)
                    .search(this.value)
                    .draw();
            });

            $('#column4_search').on('keyup', function () {
                datatable
                    .columns(4)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>
@endpush
