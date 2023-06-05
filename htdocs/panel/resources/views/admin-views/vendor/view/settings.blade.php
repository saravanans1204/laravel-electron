@extends('layouts.admin.app')

@section('title',$store->name."'s Settings")

@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/admin/css/croppie.css')}}" rel="stylesheet">

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
    <!-- Page Heading -->
    <div class="tab-content">
        <div class="tab-pane fade show active" id="vendor">
            <div class="row pt-2" >
                <div class="col-md-12">
                    <div class="card h-100">
                        <div class="card-header">
                            {{translate('messages.store')}} {{translate('messages.settings')}}
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-md-center">
                                <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control" for="item_section">
                                        <span class="pr-2">{{translate('messages.item_section')}}<span class="input-label-secondary" title="{{translate('messages.show_hide_food_menu')}}"><img src="{{asset('/public/assets/admin/img/info-circle.svg')}}" alt="{{translate('messages.show_hide_food_menu')}}"></span> :</span> 
                                            <input type="checkbox" class="toggle-switch-input" onclick="location.href='{{route('admin.vendor.toggle-settings',[$store->id,$store->item_section?0:1, 'item_section'])}}'" name="item_section" id="item_section" {{$store->item_section?'checked':''}}>
                                            <span class="toggle-switch-label text">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control" for="free_delivery">
                                        <span class="pr-2">{{translate('messages.free_delivery')}}:</span> 
                                            <input type="checkbox" class="toggle-switch-input" onclick="location.href='{{route('admin.vendor.toggle-settings',[$store->id,$store->free_delivery?0:1, 'free_delivery'])}}'" id="free_delivery" {{$store->free_delivery?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control" for="schedule_order">
                                        <span class="pr-2">{{translate('messages.scheduled')}} {{translate('messages.order')}}:</span> 
                                            <input type="checkbox" class="toggle-switch-input" onclick="location.href='{{route('admin.vendor.toggle-settings',[$store->id,$store->schedule_order?0:1, 'schedule_order'])}}'" id="schedule_order" {{$store->schedule_order?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control" for="reviews_section">
                                        <span class="pr-2">{{translate('messages.reviews')}} {{translate('messages.panel')}}<span class="input-label-secondary" title="{{translate('messages.show_hide_reviews_menu')}}"><img src="{{asset('/public/assets/admin/img/info-circle.svg')}}" alt="{{translate('messages.show_hide_food_menu')}}"></span> :</span> 
                                            <input type="checkbox" class="toggle-switch-input" onclick="location.href='{{route('admin.vendor.toggle-settings',[$store->id,$store->reviews_section?0:1, 'reviews_section'])}}'" name="reviews_section" id="reviews_section" {{$store->reviews_section?'checked':''}}>
                                            <span class="toggle-switch-label text">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control" for="delivery">
                                            <span class="pr-2">{{translate('messages.delivery')}} :</span> 
                                            <input type="checkbox" name="delivery" class="toggle-switch-input" onclick="location.href='{{route('admin.vendor.toggle-settings',[$store->id,$store->delivery?0:1, 'delivery'])}}'" id="delivery" {{$store->delivery?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control" for="take_away">
                                        <span class="pr-2 text-capitalize">{{translate('messages.take_away')}}:</span> 
                                            <input type="checkbox" class="toggle-switch-input" onclick="location.href='{{route('admin.vendor.toggle-settings',[$store->id,$store->take_away?0:1, 'take_away'])}}'" id="take_away" {{$store->take_away?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control" for="self_delivery_system">
                                        <span class="pr-2 text-capitalize">{{translate('messages.self_delivery_system')}}:</span> 
                                            <input type="checkbox" class="toggle-switch-input" onclick="location.href='{{route('admin.vendor.toggle-settings',[$store->id,$store->self_delivery_system?0:1, 'self_delivery_system'])}}'" id="self_delivery_system" {{$store->self_delivery_system?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control" for="pos_system">
                                        <span class="pr-2 text-capitalize">{{translate('messages.pos_system')}}:</span> 
                                            <input type="checkbox" class="toggle-switch-input" onclick="location.href='{{route('admin.vendor.toggle-settings',[$store->id,$store->pos_system?0:1, 'pos_system'])}}'" id="pos_system" {{$store->pos_system?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                @if ($toggle_veg_non_veg && config('module.'.$store->module->module_type)['veg_non_veg'])
                                <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control" for="veg">
                                        <span class="pr-2 text-capitalize">{{translate('messages.veg')}}:</span> 
                                            <input type="checkbox" class="toggle-switch-input" onclick="location.href='{{route('admin.vendor.toggle-settings',[$store->id,$store->veg?0:1, 'veg'])}}'" id="veg" {{$store->veg?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-4 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control" for="non_veg">
                                        <span class="pr-2 text-capitalize">{{translate('messages.non_veg')}}:</span> 
                                            <input type="checkbox" class="toggle-switch-input" onclick="location.href='{{route('admin.vendor.toggle-settings',[$store->id,$store->non_veg?0:1, 'non_veg'])}}'" id="non_veg" {{$store->non_veg?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                @endif
                            </div>

                            @if (!config('module.'.$store->module->module_type)['always_open'])
                            <div class="card">
                                <div class="card-header">
                                    {{translate('messages.Daily time schedule')}}
                                </div>
                                <div class="card-body" id="schedule">
                                    @include('admin-views.vendor.view.partials._schedule', $store)
                                </div>
                            </div>
                            @endif
                            <div class="card mt-2">
                                <div class="card-header">
                                    {{translate('messages.basic')}} {{translate('messages.settings')}}
                                </div>
                                <div class="card-body">
                                    <form action="{{route('admin.vendor.update-settings',[$store['id']])}}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf 
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label class="input-label text-capitalize" for="title">{{translate('messages.minimum')}} {{translate('messages.order')}} {{translate('messages.amount')}}</label>
                                                <input type="number" name="minimum_order" step="0.01" min="0" max="100000" class="form-control" placeholder="100" value="{{$store->minimum_order??'0'}}"> 
                                            </div>
                                            @if (config('module.'.$store->module->module_type)['order_place_to_schedule_interval'])
                                            <div class="form-group col-md-4">
                                                <label class="input-label text-capitalize" for="maximum_delivery_time">{{translate('messages.minimum_processing_time')}}<span class="input-label-secondary" title="{{translate('messages.minimum_processing_time_warning')}}"><img src="{{asset('/public/assets/admin/img/info-circle.svg')}}" alt="{{translate('messages.minimum_processing_time_warning')}}"></span></label>
                                                <input type="text" name="order_place_to_schedule_interval" class="form-control" value="{{$store->order_place_to_schedule_interval}}">
                                            </div>
                                            @endif
                                            <div class="form-group col-md-4">
                                                <label class="input-label text-capitalize" for="maximum_delivery_time">{{translate('messages.approx_delivery_time')}}</label>
                                                <div class="input-group">
                                                    <input type="number" name="minimum_delivery_time" class="form-control" placeholder="Min: 10" value="{{explode('-',$store->delivery_time)[0]}}" title="{{translate('messages.minimum_delivery_time')}}">
                                                    <input type="number" name="maximum_delivery_time" class="form-control" placeholder="Max: 20" value="{{explode(' ',explode('-',$store->delivery_time)[1])[0]}}" title="{{translate('messages.maximum_delivery_time')}}">
                                                    <select name="delivery_time_type" class="form-control text-capitalize" id="" required>
                                                        <option value="min" {{explode(' ',explode('-',$store->delivery_time)[1])[1]=='min'?'selected':''}}>{{translate('messages.minutes')}}</option>
                                                        <option value="hours" {{explode(' ',explode('-',$store->delivery_time)[1])[1]=='hours'?'selected':''}}>{{translate('messages.hours')}}</option>
                                                        <option value="days" {{explode(' ',explode('-',$store->delivery_time)[1])[1]=='days'?'selected':''}}>{{translate('messages.days')}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6"> 
                                                <div class="form-group p-2 border">
                                                    <label class="d-flex justify-content-between switch toggle-switch-sm text-dark text-capitalize" for="comission_status">
                                                        <span>{{translate('messages.admin_commission')}}(%) <span class="input-label-secondary" title="{{translate('messages.if_sales_commission_disabled_system_default_will_be_applicable')}}"><img src="{{asset('/public/assets/admin/img/info-circle.svg')}}" alt="{{translate('messages.if_sales_commission_disabled_system_default_will_be_applicable')}}"></span></span>
                                                        <input type="checkbox" class="toggle-switch-input" name="comission_status" id="comission_status" value="1" {{isset($store->comission)?'checked':''}}>
                                                        <span class="toggle-switch-label">
                                                            <span class="toggle-switch-indicator"></span>
                                                        </span>
                                                    </label>
                                                    <input type="number" id="comission" min="0" max="10000" step="0.01" name="comission" class="form-control" required value="{{$store->comission??'0'}}" {{isset($store->comission)?'':'readonly'}}>
                                                </div>
                                            </div>
                                            <div class="col-6"> 
                                                <div class="form-group p-2 border">
                                                    <label class="d-flex justify-content-between switch toggle-switch-sm text-dark" for="tax">
                                                        <span>{{translate('messages.vat/tax')}}(%)</span>
                                                    </label>
                                                    <input type="number" id="tax" min="0" max="10000" step="0.01" name="tax" class="form-control" required value="{{$store->tax??'0'}}" {{isset($store->tax)?'':'readonly'}}>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">{{translate('messages.update')}}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create schedule modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{translate('messages.Create Schedule')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:" method="post" id="add-schedule">
                    @csrf
                    <input type="hidden" name="day" id="day_id_input">
                    <input type="hidden" name="store_id" value="{{$store->id}}">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">{{translate('messages.Start time')}}:</label>
                        <input type="time" class="form-control" name="start_time" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">{{translate('messages.End time')}}:</label>
                        <input type="time" class="form-control" name="end_time" required>
                    </div>
                    <button type="submit" class="btn btn-primary">{{translate('messages.Submit')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script_2')
    <!-- Page level plugins -->
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();

            $('#exampleModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var day_name = button.data('day');
                var day_id = button.data('dayid');
                var modal = $(this);
                modal.find('.modal-title').text('{{translate('messages.Create Schedule For ')}} ' + day_name);
                modal.find('.modal-body input[name=day]').val(day_id);
            })
        });
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
            $("#comission_status").on('change', function(){
                if($("#comission_status").is(':checked')){
                    $('#comission').removeAttr('readonly');
                } else {
                    $('#comission').attr('readonly', true);
                    $('#comission').val('0');
                }
            });

        });

        function delete_schedule(route) {
            Swal.fire({
                title: '{{translate('messages.are_you_sure')}}',
                text: '{{translate('messages.You want to remove this schedule')}}',
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#377dff',
                cancelButtonText: '{{translate('messages.no')}}',
                confirmButtonText: '{{translate('messages.yes')}}',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.get({
                        url: route,
                        beforeSend: function () {
                            $('#loading').show();
                        },
                        success: function (data) {
                            if (data.errors) {
                                for (var i = 0; i < data.errors.length; i++) {
                                    toastr.error(data.errors[i].message, {
                                        CloseButton: true,
                                        ProgressBar: true
                                    });
                                }
                            } else {
                                $('#schedule').empty().html(data.view);
                                toastr.success('{{translate('messages.Schedule removed successfully')}}', {
                                    CloseButton: true,
                                    ProgressBar: true
                                });
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            toastr.error('{{translate('messages.Schedule not found')}}', {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        },
                        complete: function () {
                            $('#loading').hide();
                        },
                    });
                }
            })
        };

        $('#add-schedule').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.vendor.add-schedule')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        $('#schedule').empty().html(data.view);
                        $('#exampleModal').modal('hide');
                        toastr.success('{{translate('messages.Schedule added successfully')}}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    toastr.error(XMLHttpRequest.responseText, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
@endpush
