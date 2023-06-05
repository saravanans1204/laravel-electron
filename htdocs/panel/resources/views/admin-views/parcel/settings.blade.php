@extends('layouts.admin.app')

@section('title',translate('messages.parcel_settings'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title text-capitalize">{{translate('messages.parcel_settings')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        @php($parcel_per_km_shipping_charge=\App\Models\BusinessSetting::where(['key'=>'parcel_per_km_shipping_charge'])->first())
        @php($parcel_per_km_shipping_charge=$parcel_per_km_shipping_charge?$parcel_per_km_shipping_charge->value:null)

        @php($parcel_minimum_shipping_charge=\App\Models\BusinessSetting::where(['key'=>'parcel_minimum_shipping_charge'])->first())
        @php($parcel_minimum_shipping_charge=$parcel_minimum_shipping_charge?$parcel_minimum_shipping_charge->value:null)

        @php($parcel_commission_dm=\App\Models\BusinessSetting::where(['key'=>'parcel_commission_dm'])->first())
        @php($parcel_commission_dm=$parcel_commission_dm?$parcel_commission_dm->value:null)

        <div class="card">
            <div class="card-body">
                <div class="row gx-2 gx-lg-3">
                    <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                        <form action="{{route('admin.parcel.update.settings')}}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label  class="input-label d-inline text-capitalize">{{translate('messages.per_km_shipping_charge')}}</label>
                                        <input type="number" step=".01" placeholder="{{translate('messages.per_km_shipping_charge')}}" class="form-control" name="parcel_per_km_shipping_charge"
                                            value="{{env('APP_MODE')!='demo'?$parcel_per_km_shipping_charge??'':''}}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="input-label d-inline text-capitalize">{{translate('messages.minimum_shipping_charge')}}</label>
                                        <input type="number" step=".01" placeholder="{{translate('messages.minimum_shipping_charge')}}" class="form-control" name="parcel_minimum_shipping_charge"
                                            value="{{env('APP_MODE')!='demo'?$parcel_minimum_shipping_charge??'':''}}">
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="input-label d-inline text-capitalize">{{translate('messages.deliveryman_commission')}} (%)</label>
                                        <input type="number" step=".01" placeholder="{{translate('messages.deliveryman_commission')}}" class="form-control" name="parcel_commission_dm" max="100" value="{{env('APP_MODE')!='demo'?$parcel_commission_dm??'':''}}">
                                    </div>
                                </div>
                            </div>
                            <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn-primary mb-2">{{translate('messages.submit')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('script_2')

@endpush
