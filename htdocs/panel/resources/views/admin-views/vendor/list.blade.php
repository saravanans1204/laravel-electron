@extends('layouts.admin.app')

@section('title','Vendor List')

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-filter-list"></i> {{translate('messages.stores')}} <span class="badge badge-soft-dark ml-2" id="itemCount">{{$stores->total()}}</span></h1>
                </div>

                <div class="col-sm mb-1 mb-sm-0">
                    <select name="module_id" class="form-control js-select2-custom"
                            onchange="set_filter('{{url()->full()}}',this.value,'module_id')" title="{{translate('messages.select')}} {{translate('messages.modules')}}">
                        <option value="" {{!request('module_id') ? 'selected':''}}>{{translate('messages.all')}} {{translate('messages.modules')}}</option>
                        @foreach (\App\Models\Module::notParcel()->get() as $module)
                            <option
                                value="{{$module->id}}" {{request('module_id') == $module->id?'selected':''}}>
                                {{$module['module_name']}}
                            </option>
                        @endforeach
                    </select>
                </div>
                @if(!isset(auth('admin')->user()->zone_id))
                <div class="col-sm" style="min-width: 306px;">
                    <select name="zone_id" class="form-control js-select2-custom"
                            onchange="set_filter('{{url()->full()}}',this.value,'zone_id')">
                        <option value="" {{!request('zone_id')?'selected':''}}>All Zones</option>
                        @foreach(\App\Models\Zone::orderBy('name')->get() as $z)
                            <option
                                value="{{$z['id']}}" {{isset($zone) && $zone->id == $z['id']?'selected':''}}>
                                {{$z['name']}}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header pb-1 pt-1" >
                        <h5>{{translate('messages.stores')}} {{translate('messages.list')}}</h5>
                        <form action="javascript:" id="search-form" >
                                        <!-- Search -->
                            @csrf
                            <div class="input-group input-group-merge input-group-flush">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch_" type="search" name="search" class="form-control"
                                        placeholder="{{translate('messages.search')}}" aria-label="{{translate('messages.search')}}" required>
                                <button type="submit" class="btn btn-light">{{translate('messages.search')}}</button>

                            </div>
                            <!-- End Search -->
                        </form>
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                               class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true,
                                 "paging":false

                               }'>
                            <thead class="thead-light">
                            <tr>
                                <th style="width: 5%;">{{translate('messages.#')}}</th>
                                <th style="width: 10%;">{{translate('messages.logo')}}</th>
                                <th style="width: 15%;">{{translate('messages.store')}}</th>
                                <th style="width: 15%;">{{translate('messages.module')}}</th>
                                <th style="width: 15%;">{{translate('messages.owner')}}</th>
                                <th style="width: 10%;">{{translate('messages.zone')}}</th>
                                <th style="width: 10%;">{{translate('messages.phone')}}</th>
                                <th class="text-uppercase" style="width: 10%;">{{translate('messages.featured')}}</th>
                                <th class="text-uppercase" style="width: 10%;">{{translate('messages.active')}}/{{translate('messages.inactive')}}</th>
                                <th style="width: 10%;">{{translate('messages.action')}}</th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                            @foreach($stores as $key=>$store)
                                <tr>
                                    <td>{{$key+$stores->firstItem()}}</td>
                                    <td>
                                        <div style="height: 60px; width: 60px; overflow-x: hidden;overflow-y: hidden">
                                            <a href="{{route('admin.vendor.view', $store->id)}}" alt="view store">
                                            <img width="60" style="border-radius: 50%; height:100%;"
                                                 onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                                 src="{{asset('storage/app/public/store')}}/{{$store['logo']}}"></a>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{route('admin.vendor.view', $store->id)}}" alt="view store">
                                            <span class="d-block font-size-sm text-body">
                                                {{Str::limit($store->name,20,'...')}}<br>
                                                {{translate('messages.id')}}:{{$store->id}}
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="d-block font-size-sm text-body">
                                            {{Str::limit($store->module->module_name,20,'...')}}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="d-block font-size-sm text-body">
                                            {{Str::limit($store->vendor->f_name.' '.$store->vendor->l_name,20,'...')}}
                                        </span>
                                    </td>
                                    <td>
                                        {{$store->zone?$store->zone->name:translate('messages.zone').' '.translate('messages.deleted')}}
                                        {{--<span class="d-block font-size-sm">{{$banner['image']}}</span>--}}
                                    </td>
                                    <td>
                                        {{$store['phone']}}
                                    </td>
                                    <td>
                                        <label class="toggle-switch toggle-switch-sm" for="featuredCheckbox{{$store->id}}">
                                            <input type="checkbox" onclick="location.href='{{route('admin.vendor.featured',[$store->id,$store->featured?0:1])}}'" class="toggle-switch-input" id="featuredCheckbox{{$store->id}}" {{$store->featured?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </td>

                                    <td>
                                        @if(isset($store->vendor->status))
                                            @if($store->vendor->status)
                                            <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox{{$store->id}}">
                                                <input type="checkbox" onclick="status_change_alert('{{route('admin.vendor.status',[$store->id,$store->status?0:1])}}', '{{translate('messages.you_want_to_change_this_store_status')}}', event)" class="toggle-switch-input" id="stocksCheckbox{{$store->id}}" {{$store->status?'checked':''}}>
                                                <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                            @else
                                            <span class="badge badge-soft-danger">{{translate('messages.denied')}}</span>
                                            @endif
                                        @else
                                            <span class="badge badge-soft-danger">{{translate('messages.pending')}}</span>
                                        @endif
                                    </td>
                                    
                                    <td>
                                        <a class="btn btn-sm btn-white"
                                            href="{{route('admin.vendor.view',[$store['id']])}}" title="{{translate('messages.view')}} {{translate('messages.store')}}"><i class="tio-visible text-success"></i>
                                        </a>
                                        <a class="btn btn-sm btn-white"
                                            href="{{route('admin.vendor.edit',[$store['id']])}}" title="{{translate('messages.edit')}} {{translate('messages.store')}}"><i class="tio-edit text-primary"></i>
                                        </a>
                                        <a class="btn btn-sm btn-white" href="javascript:"
                                        onclick="form_alert('vendor-{{$store['id']}}','{{translate('You want to remove this store')}}')" title="{{translate('messages.delete')}} {{translate('messages.store')}}"><i class="tio-delete-outlined text-danger"></i>
                                        </a>
                                        <form action="{{route('admin.vendor.delete',[$store['id']])}}" method="post" id="vendor-{{$store['id']}}">
                                            @csrf @method('delete')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <hr>

                        <div class="page-area">
                            <table>
                                <tfoot>
                                {!! $stores->links() !!}
                                </tfoot>
                            </table>
                        </div>

                    </div>
                    <!-- End Table -->
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        function status_change_alert(url, message, e) {
            e.preventDefault();
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
                    location.href=url;
                }
            })
        }
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

            $('#column3_search').on('keyup', function () {
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

    <script>
        $('#search-form').on('submit', function () {
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.vendor.search')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('#itemCount').html(data.total);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
@endpush
