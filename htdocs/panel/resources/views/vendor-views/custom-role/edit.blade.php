@extends('layouts.vendor.app')
@section('title','Edit Role')
@push('css_or_js')

@endpush

@section('content')
<div class="content container-fluid"> 
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('vendor.dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Role Update</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-black-50">{{translate('messages.custom_role')}}</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('vendor.custom-role.update',[$role['id']])}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{translate('messages.role_name')}}</label>
                            <input type="text" name="name" value="{{$role['name']}}" class="form-control" id="name" aria-describedby="emailHelp"
                                   placeholder="{{translate('role_name_example')}}">
                        </div>

                        <label for="module">{{translate('messages.module_permission')}} : </label>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="item" class="form-check-input"
                                           id="item" {{in_array('item',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont" for="item">{{translate('messages.item')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="order" class="form-check-input"
                                           id="order" {{in_array('order',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont" for="order">{{translate('messages.order')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="store_setup" class="form-check-input"
                                           id="store_setup" {{in_array('store_setup',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont" for="store_setup">{{translate('messages.business')}} {{translate('messages.setup')}}</label>
                                </div>
                            </div>
                            @if (config('module.'.\App\CentralLogics\Helpers::get_store_data()->module->module_type)['add_on'])
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="addon" class="form-check-input"
                                           id="addon" {{in_array('addon',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont" for="addon">{{translate('messages.addon')}}</label>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="wallet" class="form-check-input"
                                           id="wallet" {{in_array('wallet',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont" for="wallet">{{translate('messages.wallet')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="bank_info" class="form-check-input"
                                           id="bank_info" {{in_array('bank_info',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont" for="bank_info">{{translate('messages.bank_info')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="employee" class="form-check-input"
                                           id="employee" {{in_array('employee',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont" for="employee">{{translate('messages.Employee')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="my_shop" class="form-check-input"
                                           id="my_shop" {{in_array('my_shop',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont" for="my_shop">{{translate('messages.my_shop')}}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="custom_role" class="form-check-input"
                                           id="custom_role" {{in_array('custom_role',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont" for="custom_role">{{translate('messages.custom_role')}}</label>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="campaign" class="form-check-input"
                                           id="campaign" {{in_array('campaign',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont" for="campaign">{{translate('messages.campaign')}}</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="reviews" class="form-check-input"
                                           id="reviews" {{in_array('reviews',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont" for="reviews">{{translate('messages.reviews')}}</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="pos" class="form-check-input"
                                           id="pos" {{in_array('pos',(array)json_decode($role['modules']))?'checked':''}}>
                                    <label class="form-check-label qcont" for="pos">{{translate('messages.pos')}}</label>
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
@endsection

@push('script')

@endpush
