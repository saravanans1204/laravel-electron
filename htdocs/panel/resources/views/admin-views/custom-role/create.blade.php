@extends('layouts.admin.app')
@section('title',translate('messages.custom_role'))
@push('css_or_js')

@endpush

@section('content')
<div class="content container-fluid"> 
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{translate('messages.dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{translate('messages.employee')}} {{translate('messages.Role')}}</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-black-50">{{translate('messages.employee')}} {{translate('messages.Role')}}</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{translate('messages.role_form')}}
                </div>
                <div class="card-body">
                    <form action="{{route('admin.custom-role.create')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label class="input-label qcont" for="name">{{translate('messages.role_name')}}</label>
                            <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp"
                                   placeholder="{{translate('role_name_example')}}" required value="{{old('name')}}">
                        </div>

                        <label class="input-label qcont" for="name">{{translate('messages.module_permission')}} : </label>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="account" class="form-check-input"
                                           id="account">
                                    <label class="form-check-label qcont text-dark" for="account">{{translate('messages.collect')}} {{translate('messages.cash')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="addon" class="form-check-input"
                                           id="addon">
                                    <label class="form-check-label qcont text-dark" for="addon">{{translate('messages.addon')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="attribute" class="form-check-input"
                                           id="attribute">
                                    <label class="form-check-label qcont text-dark" for="attribute">{{translate('messages.attribute')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="banner" class="form-check-input"
                                           id="banner">
                                    <label class="form-check-label qcont text-dark" for="banner">{{translate('messages.banner')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="campaign" class="form-check-input"
                                           id="campaign">
                                    <label class="form-check-label qcont text-dark" for="campaign">{{translate('messages.campaign')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="category" class="form-check-input"
                                           id="category">
                                    <label class="form-check-label qcont text-dark" for="category">{{translate('messages.category')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="coupon" class="form-check-input"
                                           id="coupon">
                                    <label class="form-check-label qcont text-dark" for="coupon">{{translate('messages.coupon')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="custom_role" class="form-check-input"
                                           id="custom_role">
                                    <label class="form-check-label qcont text-dark" for="custom_role">{{translate('messages.custom_role')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="customerList" class="form-check-input"
                                           id="customerList">
                                    <label class="form-check-label qcont text-dark" for="customerList">{{translate('messages.customers')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="deliveryman" class="form-check-input"
                                           id="deliveryman">
                                    <label class="form-check-label qcont text-dark" for="deliveryman">{{translate('messages.deliveryman')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="provide_dm_earning" class="form-check-input"
                                           id="provide_dm_earning">
                                    <label class="form-check-label qcont text-dark" for="provide_dm_earning">{{translate('messages.deliverymen_earning_provide')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="employee" class="form-check-input"
                                           id="employee">
                                    <label class="form-check-label qcont text-dark" for="employee">{{translate('messages.Employee')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="item" class="form-check-input"
                                           id="item">
                                    <label class="form-check-label qcont text-dark" for="item">{{translate('messages.item')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="notification" class="form-check-input"
                                           id="notification">
                                    <label class="form-check-label qcont text-dark" for="notification">{{translate('messages.push')}} {{translate('messages.notification')}} </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="order" class="form-check-input"
                                           id="order">
                                    <label class="form-check-label qcont text-dark" for="order">{{translate('messages.order')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="store" class="form-check-input"
                                           id="store">
                                    <label class="form-check-label qcont text-dark" for="store">{{translate('messages.stores')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="report" class="form-check-input"
                                            id="report">
                                    <label class="form-check-label qcont text-dark" for="report">{{translate('messages.report')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="settings" class="form-check-input"
                                           id="settings">
                                    <label class="form-check-label qcont text-dark" for="settings">{{translate('messages.business')}} {{translate('messages.settings')}}</label>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="withdraw_list" class="form-check-input"
                                            id="withdraw_list">
                                    <label class="form-check-label qcont text-dark" for="withdraw_list">{{translate('messages.store')}} {{translate('messages.withdraws')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="zone" class="form-check-input"
                                           id="zone">
                                    <label class="form-check-label qcont text-dark" for="zone">{{translate('messages.zone')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="module" class="form-check-input"
                                           id="module_system">
                                    <label class="form-check-label qcont text-dark" for="module_system">{{translate('messages.module')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="parcel" class="form-check-input"
                                           id="parcel">
                                    <label class="form-check-label qcont text-dark" for="parcel">{{translate('messages.parcel')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="pos" class="form-check-input"
                                           id="pos">
                                    <label class="form-check-label qcont text-dark" for="pos">{{translate('messages.pos_system')}}</label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">{{translate('messages.submit')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-0">
                    <h5>{{translate('messages.roles_table')}} <span class="badge badge-soft-dark ml-2" id="itemCount">{{$rl->total()}}</span></h5>
                    <form action="javascript:" id="search-form">
                        @csrf
                        <!-- Search -->
                        <div class="input-group input-group-merge input-group-flush">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tio-search"></i>
                                </div>
                            </div>
                            <input id="datatableSearch_" type="search" name="search" class="form-control" placeholder="Search" aria-label="Search">
                            <button type="submit" class="btn btn-light">{{translate('messages.search')}}</button>
                        </div>
                        <!-- End Search -->
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                               class="table table-borderless table-thead-bordered table-align-middle card-table"
                               data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true,
                                 "paging":false
                               }'>
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" style="width: 50px">{{translate('messages.sl#')}}</th>
                                <th scope="col" style="width: 50px">{{translate('messages.role_name')}}</th>
                                <th scope="col" style="width: 200px">{{translate('messages.modules')}}</th>
                                <th scope="col" style="width: 50px">{{translate('messages.created_at')}}</th>
                                {{--<th scope="col" style="width: 50px">{{translate('messages.status')}}</th>--}}
                                <th scope="col" style="width: 50px">{{translate('messages.action')}}</th>
                            </tr>
                            </thead>
                            <tbody  id="set-rows">
                            @foreach($rl as $k=>$r)
                                <tr>
                                    <td scope="row">{{$k+$rl->firstItem()}}</td>
                                    <td>{{Str::limit($r['name'],25,'...')}}</td>
                                    <td class="text-capitalize">
                                        @if($r['modules']!=null)
                                            @foreach((array)json_decode($r['modules']) as $key=>$m)
                                               {{str_replace('_',' ',$m)}},
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{date('d-M-y',strtotime($r['created_at']))}}</td>
                                    {{--<td>
                                        {{$r->status?'Active':'Inactive'}}
                                    </td>--}}
                                    <td>
                                        <a class="btn btn-sm btn-white"
                                            href="{{route('admin.custom-role.edit',[$r['id']])}}" title="{{translate('messages.edit')}} {{translate('messages.role')}}"><i class="tio-edit"></i>
                                        </a>
                                        <a class="btn btn-sm btn-danger" href="javascript:"
                                            onclick="form_alert('role-{{$r['id']}}','{{translate('messages.Want_to_delete_this_role')}}')" title="{{translate('messages.delete')}} {{translate('messages.role')}}"><i class="tio-delete-outlined"></i>
                                        </a>
                                        <form action="{{route('admin.custom-role.delete',[$r['id']])}}"
                                                method="post" id="role-{{$r['id']}}">
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
                                {!! $rl->links() !!}
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script_2')
    <script>
        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.custom-role.search')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('#itemCount').html(data.count);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
        $(document).ready(function() {
            var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));
        });
    </script>
@endpush
