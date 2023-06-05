@extends('layouts.admin.app')

@section('title',translate('messages.Update Unit'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title text-capitalize" ><i class="tio-edit"></i> {{translate('messages.unit')}} {{translate('messages.update')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{route('admin.unit.update',[$unit['id']])}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group lang_form">
                                <label class="input-label" for="exampleFormControlInput1">{{translate('messages.name')}}</label>
                                <input type="text" name="unit" class="form-control" placeholder="{{translate('messages.new_unit')}}" maxlength="191" value="{{ $unit['unit'] }}" required>
                            </div>
                        </div>
                    </div>
   
                    <button type="submit" class="btn btn-primary">{{translate('messages.update')}}</button>
                </form>
            </div>
            <!-- End Table -->
        </div>
    </div>

@endsection

@push('script_2')

@endpush
