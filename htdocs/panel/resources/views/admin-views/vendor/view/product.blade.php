@extends('layouts.admin.app')

@section('title',$store->name."'s Items")

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
    @php($foods = \App\Models\Item::withoutGlobalScope(\App\Scopes\StoreScope::class)->where('store_id', $store->id)->latest()->paginate(25))
    <div class="tab-content">
        <div class="tab-pane fade show active" id="product">
            <div class="row pt-2">
                <div class="col-md-12">
                    <div class="card h-100">
                        <div class="card-header">
                            <h3>{{translate('messages.items')}} <span class="badge badge-soft-dark ml-2">{{$foods->total()}}</span></h3>
                            
                            <a href="{{route('admin.item.add-new')}}" class="btn btn-primary pull-right"><i
                                        class="tio-add-circle"></i> {{translate('messages.add')}} {{translate('messages.new')}} {{translate('messages.item')}}</a>
                        </div>
                        <div class="table-responsive datatable-custom">
                            <table id="columnSearchDatatable"
                                    class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                    data-hs-datatables-options='{
                                        "order": [],
                                        "orderCellsTop": true,
                                        "paging": false
                                    }'>
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{translate('messages.#')}}</th>
                                        <th style="width: 20%">{{translate('messages.name')}}</th>
                                        <th style="width: 20%">{{translate('messages.type')}}</th>
                                        <th>{{translate('messages.price')}}</th>
                                        <th>{{translate('messages.status')}}</th>
                                        <th>{{translate('messages.action')}}</th>
                                    </tr>
                                </thead>

                                <tbody id="set-rows">
                                @php($foods = \App\Models\Item::withoutGlobalScope(\App\Scopes\StoreScope::class)->where('store_id', $store->id)->latest()->paginate(25))
                                @foreach($foods as $key=>$food)
                                    
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>
                                        <a class="media align-items-center" href="{{route('admin.item.view',[$food['id']])}}">
                                            <img class="avatar avatar-lg mr-3" src="{{asset('storage/app/public/product')}}/{{$food['image']}}" 
                                                 onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'" alt="{{$food->name}} image">
                                            <div class="media-body">
                                                <h5 class="text-hover-primary mb-0">{{Str::limit($food['name'],20,'...')}}</h5>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                    {{Str::limit($food->category?$food->category->name:translate('messages.category_deleted'),20,'...')}}
                                    </td>
                                    <td>{{\App\CentralLogics\Helpers::format_currency($food['price'])}}</td>
                                    <td>
                                        <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox{{$food->id}}">
                                            <input type="checkbox" onclick="location.href='{{route('admin.item.status',[$food['id'],$food->status?0:1])}}'"class="toggle-switch-input" id="stocksCheckbox{{$food->id}}" {{$food->status?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-white"
                                            href="{{route('admin.item.edit',[$food['id']])}}" title="{{translate('messages.edit')}} {{translate('messages.item')}}"><i class="tio-edit"></i>
                                        </a>
                                        <a class="btn btn-sm btn-white" href="javascript:"
                                            onclick="form_alert('food-{{$food['id']}}','Want to delete this item ?')" title="{{translate('messages.delete')}} {{translate('messages.item')}}"><i class="tio-delete-outlined"></i>
                                        </a>
                                        <form action="{{route('admin.item.delete',[$food['id']])}}"
                                                method="post" id="food-{{$food['id']}}">
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
                                    <tfoot class="border-top">
                                    {!! $foods->links() !!}
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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
        });

        $('#search-form').on('submit', function () {
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.item.search')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
@endpush
