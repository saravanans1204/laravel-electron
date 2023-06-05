@extends('layouts.admin.app')

@section('title',translate('Stock report'))

@push('css_or_js')

@endpush

@section('content')

    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-12 mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-filter-list"></i> {{translate('Stock report')}}</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-12 mb-2">
                    <select name="module_id" class="form-control js-select2-custom" onchange="set_filter('{{url()->full()}}',this.value,'module_id')" title="{{translate('messages.select')}} {{translate('messages.modules')}}">
                        <option value="" {{!request('module_id') ? 'selected':''}}>{{translate('messages.all')}} {{translate('messages.modules')}}</option>
                        @foreach (\App\Models\Module::notParcel()->get() as $module)
                            @if (config('module.'.$module->module_type)['stock'])
                                <option
                                    value="{{$module->id}}" {{request('module_id') == $module->id?'selected':''}}>
                                    {{$module['module_name']}}
                                </option>                                
                            @endif

                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4 col-12 mb-2">
                    <select name="zone_id" class="form-control js-select2-custom"
                            onchange="set_zone_filter('{{url()->full()}}',this.value)" id="zone">
                        <option value="all">{{translate('All Zones')}}</option>
                        @foreach(\App\Models\Zone::orderBy('name')->get() as $z)
                            <option
                                value="{{$z['id']}}" {{isset($zone) && $zone->id == $z['id']?'selected':''}}>
                                {{($z['name'])}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4 col-12">
                    <select name="store_id" onchange="set_store_filter('{{url()->full()}}',this.value)" data-placeholder="{{translate('messages.select')}} {{translate('messages.store')}}" class="js-data-example-ajax form-control">
                        @if(isset($store))    
                        <option value="{{$store->id}}" selected>{{$store->name}}</option>
                        @else
                        <option value="all" selected>{{translate('messages.all')}} {{translate('messages.stores')}}</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Card -->
        <div class="row card mt-4">
            <!-- Header -->
            <div class="card-header py-0">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <form id="search-form">
                        <!-- Search -->
                        <div class="input-group input-group-merge input-group-flush">
                            <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tio-search"></i>
                            </div>
                            </div>
                            <input id="datatableSearch" name="search" type="search" class="form-control" placeholder="{{translate('messages.search_here')}}" aria-label="{{translate('messages.search_here')}}" value="{{request()->query('search')}}">
                            <button type="submit" class="btn btn-light">{{translate('messages.search')}}</button>
                        </div>
                        <!-- End Search -->
                        </form>
                    </div>
                </div>
                <!-- End Row -->
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom" id="table-div">
                <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap card-table"
                    data-hs-datatables-options='{
                        "columnDefs": [{
                            "targets": [],
                            "width": "5%",
                            "orderable": false
                        }],
                        "order": [],
                        "info": {
                        "totalQty": "#datatableWithPaginationInfoTotalQty"
                        },

                        "entries": "#datatableEntries",

                        "isResponsive": false,
                        "isShowPaging": false,
                        "paging":false
                    }'>
                    <thead class="thead-light">
                    <tr>
                        <th>{{translate('messages.#')}}</th>
                        <th style="width: 20%">{{translate('messages.name')}}</th>
                        <th style="width: 15%">{{translate('messages.store')}}</th>
                        <th>{{translate('messages.zone')}}</th>
                        <th>{{translate('Current stock')}}</th>
                        <th>{{translate('messages.action')}}</th>
                    </tr>
                    </thead>

                    <tbody id="set-rows">
                    
                    @foreach($items as $key=>$item)
                        <tr>
                            <td>{{$key+$items->firstItem()}}</td>
                            <td>
                                <a class="media align-items-center" href="{{route('admin.item.view',[$item['id']])}}">
                                    <img class="avatar avatar-lg mr-3" src="{{asset('storage/app/public/product')}}/{{$item['image']}}" 
                                            onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'" alt="{{$item->name}} image">
                                    <div class="media-body">
                                        <h5 class="text-hover-primary mb-0">{{$item['name']}}</h5>
                                    </div>
                                </a>
                            </td>
                            <td>
                                @if($item->store)
                                {{Str::limit($item->store->name,25,'...')}}
                                @else
                                {{translate('messages.store')}} {{translate('messages.deleted')}}
                                @endif
                            </td>
                            <td>
                                @if($item->store)
                                    {{$item->store->zone->name}}
                                @else
                                    {{translate('messages.not_found')}}
                                @endif
                            </td>
                            <td>
                                {{$item->stock}}
                            </td>
                            <td>
                                <a class="btn btn-sm btn-white"
                                    href="{{route('admin.item.edit',[$item['id']])}}" title="{{translate('messages.edit')}} {{translate('messages.item')}}"><i class="tio-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <hr>
                <div class="page-area">
                    <table>
                        <tfoot class="border-top">
                        {!! $items->links() !!}
                        </tfoot>
                    </table>
                </div>
            </div>
            <!-- End Table -->
        </div>
        <!-- End Card -->
    </div>
@endsection

@push('script')

@endpush

@push('script_2')

    <script src="{{asset('public/assets/admin')}}/vendor/chart.js/dist/Chart.min.js"></script>
    <script
        src="{{asset('public/assets/admin')}}/vendor/chartjs-chart-matrix/dist/chartjs-chart-matrix.min.js"></script>
    <script src="{{asset('public/assets/admin')}}/js/hs.chartjs-matrix.js"></script>

    <script>
        $(document).on('ready', function () {
            $('.js-data-example-ajax').select2({
                ajax: {
                    url: '{{url('/')}}/admin/vendor/get-stores',
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            // all:true,
                    @if(isset($zone))zone_ids: [{{$zone->id}}], @endif
                    @if(request('module_id'))module_id: {{request('module_id')}}, @endif
                            page: params.page
                        };
                    },
                    processResults: function (data) {
                        return {
                        results: data
                        };
                    },
                    __port: function (params, success, failure) {
                        var $request = $.ajax(params);

                        $request.then(success);
                        $request.fail(failure);

                        return $request;
                    }
                }
            });
        });
    </script>

    <script>        
        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            set_filter('{!! url()->full() !!}', $('#datatableSearch').val(), 'search');
        });
    </script>
@endpush
