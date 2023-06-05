@extends('layouts.admin.app')

@section('title',translate('messages.modules'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">{{translate('messages.module')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="card mt-3">
            <div class="card-header pb-0">
                <h5>{{translate('messages.module')}} {{translate('messages.list')}}<span class="badge badge-soft-dark ml-2" id="itemCount">{{$modules->total()}}</span></h5>
                {{--<form id="dataSearch">
                    @csrf
                    <!-- Search -->
                    <div class="input-group input-group-merge input-group-flush">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tio-search"></i>
                            </div>
                        </div>
                        <input type="search" name="search" class="form-control" placeholder="{{translate('messages.search_categories')}}" aria-label="{{translate('messages.search_categories')}}">
                        <button type="submit" class="btn btn-light">{{translate('messages.search')}}</button>
                    </div>
                    <!-- End Search -->
                </form>--}}
            </div>
            <div class="card-body">
                <div class="table-responsive datatable-custom">
                    <table id="columnSearchDatatable"
                        class="table table-borderless table-thead-bordered table-align-middle" style="width:100%;"
                        data-hs-datatables-options='{
                            "isResponsive": false,
                            "isShowPaging": false,
                            "paging":false,
                        }'>
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 5%">{{translate('messages.#')}}</th>
                                <th style="width: 10%">{{translate('messages.id')}}</th>
                                <th style="width: 20%">{{translate('messages.name')}}</th>
                                <th style="width: 20%">{{translate('messages.module_type')}}</th>
                                <th style="width: 10%">{{translate('messages.status')}}</th>
                                <th style="width: 20%">{{translate('messages.store_count')}}</th>
                                <th style="width: 15%">{{translate('messages.action')}}</th>
                            </tr>
                        </thead>

                        <tbody id="table-div">
                        @foreach($modules as $key=>$module)
                            <tr>
                                <td>{{$key+$modules->firstItem()}}</td>
                                <td>{{$module->id}}</td>
                                <td>
                                    <span class="d-block font-size-sm text-body">
                                        {{Str::limit($module['module_name'], 20,'...')}}
                                    </span>
                                </td>
                                <td>
                                    <span class="d-block font-size-sm text-body text-capitalize">
                                        {{Str::limit($module['module_type'], 20,'...')}}
                                    </span>
                                </td>
                                <td>
                                    <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox{{$module->id}}">
                                    <input type="checkbox" onclick="location.href='{{route('admin.module.status',[$module['id'],$module->status?0:1])}}'"class="toggle-switch-input" id="stocksCheckbox{{$module->id}}" {{$module->status?'checked':''}}>
                                        <span class="toggle-switch-label">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
                                </td>
                                <td>{{$module->stores_count}}</td>
                                <td>
                                    <a class="btn btn-sm btn-white"
                                        href="{{route('admin.module.edit',[$module['id']])}}" title="{{translate('messages.edit')}} {{translate('messages.category')}}"><i class="tio-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer page-area">
                <!-- Pagination -->
                <div class="row justify-content-center justify-content-sm-between align-items-sm-center"> 
                    <div class="col-sm-auto">
                        <div class="d-flex justify-content-center justify-content-sm-end">
                            <!-- Pagination -->
                            {!! $modules->links() !!}
                        </div>
                    </div>
                </div>
                <!-- End Pagination -->
            </div>
        </div>

    </div>

@endsection

@push('script_2')
    <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            

            {{--
                $('#dataSearch').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post({
                    url: '{{route('admin.module.search')}}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('#loading').show();
                    },
                    success: function (data) {
                        $('#table-div').html(data.view);
                        $('#itemCount').html(data.count);
                        $('.page-area').hide();
                    },
                    complete: function () {
                        $('#loading').hide();
                    },
                });
            });
            --}}


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>
@endpush
