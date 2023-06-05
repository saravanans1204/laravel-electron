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
    <div class="tab-content">
        <div class="tab-pane fade show active" id="product">
            <div class="row pt-2">
                <div class="col-md-12">
                    <div class="card h-100">
                        <div class="card-header">
                            {{translate('messages.reviews')}} {{$store->reviews->count()}}
                        </div>
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
                                        <th>{{translate('messages.#')}}</th>
                                        <th>{{translate('messages.item')}}</th>
                                        <th>{{translate('messages.reviewer')}}</th>
                                        <th>{{translate('messages.review')}}</th>
                                        <th>{{translate('messages.rating')}}</th>
                                        <th>{{translate('messages.date')}}</th>
                                    </tr>
                                </thead>

                                <tbody id="set-rows">
                                @php($reviews = $store->reviews()->with('item',function($query){
                                    $query->withoutGlobalScope(\App\Scopes\StoreScope::class);
                                })->latest()->paginate(25))

                                @foreach($reviews as $key=>$review)
                                    <tr>
                                        <td>{{$key+$reviews->firstItem()}}</td>
                                        <td>
                                        @if ($review->item)
                                            <a class="media align-items-center" href="{{route('admin.item.view',[$review->item['id']])}}">
                                                <img class="avatar avatar-lg mr-3" src="{{asset('storage/app/public/product')}}/{{$review->item['image']}}" 
                                                    onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'" alt="{{$review->item->name}} image">
                                                <div class="media-body">
                                                    <h5 class="text-hover-primary mb-0">{{Str::limit($review->item['name'],10)}}</h5>
                                                </div>
                                            </a>
                                        @else
                                            {{translate('messages.Item deleted!')}}
                                        @endif
                                        </td>
                                        <td>
                                        @if($review->customer)
                                            <a class="d-flex align-items-center"
                                            href="{{route('admin.customer.view',[$review['user_id']])}}">
                                                <div class="avatar avatar-circle">
                                                    <img class="avatar-img" width="75" height="75"
                                                        onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                                        src="{{asset('storage/app/public/profile/'.$review->customer->image)}}"
                                                        alt="Image Description">
                                                </div>
                                                <div class="ml-3">
                                                <span class="d-block h5 text-hover-primary mb-0">{{Str::limit($review->customer['f_name']." ".$review->customer['l_name'], 15)}} <i
                                                        class="tio-verified text-primary" data-toggle="tooltip" data-placement="top"
                                                        title="Verified Customer"></i></span>
                                                    <span class="d-block font-size-sm text-body">{{Str::limit($review->customer->email, 20)}}</span>
                                                </div>
                                            </a>
                                        @else
                                            {{translate('messages.customer_not_found')}}
                                        @endif
                                        </td>
                                        <td>
                                            <div class="text-wrap" style="width: 18rem;">
                                                <p>
                                                    {{Str::limit($review['comment'], 80)}}
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-wrap">
                                                <div class="d-flex mb-2">
                                                    <label class="badge badge-soft-info">
                                                        {{$review->rating}} <i class="tio-star"></i>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{date('d M Y '.config('timeformat'),strtotime($review['created_at']))}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <hr>
                            <div class="page-area">
                                <table>
                                    <tfoot class="border-top">
                                    {!! $reviews->links() !!}
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
