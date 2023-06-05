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
                            {{translate('messages.discount')}} {{translate('messages.info')}}
                            <button type="button" class="btn-sm btn-primary" data-toggle="modal" data-target="#updatesettingsmodal">
                                {{$store->discount?translate('messages.update').' '.translate('messages.discount'):translate('messages.add').' '.translate('messages.discount')}}
                            </button>
                        </div>
                        <div class="card-body">
                            @if($store->discount)
                            <div class="row">
                                <div class="col-6 border-right">
                                    <ul class="list-unstyled list-unstyled-py-3 text-dark mb-3">
                                        <li class="pb-1 pt-1">{{translate('messages.start')}} {{translate('messages.date')}} : {{$store->discount?date('Y-m-d',strtotime($store->discount->start_date)):''}}</li>
                                        <li class="pb-1 pt-1">{{translate('messages.end')}} {{translate('messages.date')}} : {{$store->discount?date('Y-m-d', strtotime($store->discount->end_date)):''}}</li>
                                        <li class="pb-1 pt-1">{{translate('messages.start')}} {{translate('messages.time')}} : {{$store->discount?date(config('timeformat'), strtotime($store->discount->start_time)):''}}</li>
                                        <li class="pb-1 pt-1">{{translate('messages.end')}} {{translate('messages.time')}} : {{$store->discount?date(config('timeformat'), strtotime($store->discount->end_time)):''}}</li>
                                    </ul>
                                </div>
                                <div class="col-6">
                                    <ul class="list-unstyled list-unstyled-py-3 text-dark mb-3">
                                        <li class="pb-1 pt-1">{{translate('messages.discount')}} : {{$store->discount?round($store->discount->discount):0}}%</li>
                                        <li class="pb-1 pt-1">{{translate('messages.max')}} {{translate('messages.discount')}} : {{\App\CentralLogics\Helpers::format_currency($store->discount?$store->discount->max_discount:0)}}</li>
                                        <li class="pb-1 pt-1">{{translate('messages.min')}} {{translate('messages.purchase')}} : {{\App\CentralLogics\Helpers::format_currency($store->discount?$store->discount->min_purchase:0)}}</li>
                                    </ul>
                                </div>
                            </div>
                            @else
                            <div class="form-group">
                                <label class="d-flex justify-content-center rounded px-4 form-control" for="restaurant_status">
                                    <span class="card-subtitle">No discount</span> 
                                </label>
                            </div>
                            @endif
                            

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="updatesettingsmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">{{$store->discount?translate('messages.update'):translate('messages.add')}} {{translate('messages.discount')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('admin.vendor.discount',[$store['id']])}}" method="post" id="discount-form">
            @csrf 
            <div class="row">
                <div class="col-md-6 col-6">
                    <div class="form-group">
                        <label class="input-label" for="title">{{translate('messages.start')}} {{translate('messages.date')}}</label>
                        <input type="date" id="date_from" class="form-control" required name="start_date" value="{{$store->discount?date('Y-m-d',strtotime($store->discount->start_date)):''}}"> 
                    </div>
                </div>
                <div class="col-md-6 col-6">
                    <div class="form-group">
                        <label class="input-label" for="title">{{translate('messages.end')}} {{translate('messages.date')}}</label>
                        <input type="date" id="date_to" class="form-control" required name="end_date" value="{{$store->discount?date('Y-m-d', strtotime($store->discount->end_date)):''}}">
                    </div>

                </div>
                <div class="col-md-6 col-6">
                    <div class="form-group">
                        <label class="input-label" for="title">{{translate('messages.start')}} {{translate('messages.time')}}</label>
                        <input type="time" id="start_time" class="form-control" required name="start_time" value="{{$store->discount?date('H:i',strtotime($store->discount->start_time)):'00:00'}}">
                    </div>
                </div>
                <div class="col-md-6 col-6">
                    <label class="input-label" for="title">{{translate('messages.end')}} {{translate('messages.time')}}</label>
                    <input type="time" id="end_time" class="form-control" required name="end_time" value="{{$store->discount?date('H:i', strtotime($store->discount->end_time)):'23:59'}}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-6">
                    <div class="form-group">
                        <label class="input-label" for="title">{{translate('messages.discount')}} (%)</label>
                        <input type="number" min="0" max="10000" step="0.01" name="discount" class="form-control" required value="{{$store->discount?$store->discount->discount:'0'}}">
                    </div>
                </div>
                <div class="col-md-4 col-6">
                    <div class="form-group">
                        <label class="input-label" for="title">{{translate('messages.min')}} {{translate('messages.purchase')}} ({{\App\CentralLogics\Helpers::currency_symbol()}})</label>
                        <input type="number" name="min_purchase" step="0.01" min="0" max="100000" class="form-control" placeholder="100" value="{{$store->discount?$store->discount->min_purchase:'0'}}"> 
                    </div>
                </div>
                <div class="col-md-4 col-6">
                    <div class="form-group">
                        <label class="input-label" for="title">{{translate('messages.max')}} {{translate('messages.discount')}} ({{\App\CentralLogics\Helpers::currency_symbol()}})</label>
                        <input type="number" min="0" max="1000000" step="0.01" name="max_discount" class="form-control" value="{{$store->discount?$store->discount->max_discount:'0'}}">
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">{{$store->discount?translate('messages.update'):translate('messages.add')}}</button>
                @if($store->discount)
                <button type="button" onclick="form_alert('discount-{{$store->id}}','Want to remove discount?')" class="btn btn-danger">{{translate('messages.delete')}}</button>
                @endif
            </div>
        </form>
        <form action="{{route('admin.vendor.clear-discount',[$store->id])}}" method="post" id="discount-{{$store->id}}">
            @csrf @method('delete')
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('script_2')
    <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
            $('#date_from').attr('min',(new Date()).toISOString().split('T')[0]);
            $('#date_to').attr('min',(new Date()).toISOString().split('T')[0]);
            
            $("#date_from").on("change", function () {
                $('#date_to').attr('min',$(this).val());
            });

            $("#date_to").on("change", function () {
                $('#date_from').attr('max',$(this).val());
            });
        });

        $('#discount-form').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.vendor.discount',[$store['id']])}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success(data.message, {
                            CloseButton: true,
                            ProgressBar: true
                        });

                        setTimeout(function () {
                            location.href = '{{route('admin.vendor.view', ['store'=>$store->id, 'tab'=> 'discount'])}}';
                        }, 2000);
                    }
                }
            });
        });
    </script>
@endpush
