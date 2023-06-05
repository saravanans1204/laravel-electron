@extends('layouts.admin.app')
@section('title', 'Subscribed Emails')
@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-3">
                <div class="col-sm">
                    <h1 class="page-header-title">{{ translate('messages.subscribed_mail_list') }}
                        <span class="badge badge-soft-dark ml-2">{{ \App\Models\Newsletter::count() }}</span>
                    </h1>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->
        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-lg-6 mb-3 mb-lg-0">
                        <form action="javascript:" id="search-form">
                        {{-- <form action="{{ route('admin.customer.subscribed') }}"> --}}
                            <div class="input-group input-group-merge input-group-flush">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch_" type="search" name="search" class="form-control"
                                    value="{{ request()->get('search') }}" placeholder="{{ translate('messages.search') }}"
                                    aria-label="Search" required>
                                <button type="submit" class="btn btn-primary">{{ translate('messages.search') }}</button>
                                @if (request()->get('search'))
                                    <button type="reset" class="btn btn-info mx-1"
                                        onclick="location.href = '{{ route('admin.customer.subscribed') }}'">{{ translate('messages.reset') }}</button>
                                @endif
                            </div>
                            <!-- End Search -->
                        </form>
                    </div>
                </div>
                <!-- End Row -->
            </div>
            <!-- End Header -->
            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="datatable"
                    class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table generalData"
                    style="width: 100%" data-hs-datatables-options='{
                                                             "columnDefs": [{
                                                                "targets": [0],
                                                                "orderable": false
                                                              }],
                                                             "order": [],
                                                             "info": {
                                                               "totalQty": "#datatableWithPaginationInfoTotalQty"
                                                             },
                                                             "search": "#datatableSearch",
                                                             "entries": "#datatableEntries",
                                                             "pageLength": 25,
                                                             "isResponsive": false,
                                                             "isShowPaging": false,
                                                             "paging":false
                                                           }'>
                    <thead class="thead-light">
                        <tr>
                            <th class="">
                                {{ translate('messages.#') }}
                            </th>
                            <th>{{ translate('messages.email') }}</th>
                            <th>{{ translate('messages.created_at') }}</th>
                        </tr>
                    </thead>
                    <tbody id="set-rows">
                        @if (count($subscribedCustomers))
                            @foreach ($subscribedCustomers as $key => $customer)
                                <tr>
                                    <td>
                                        {{ ++$key }}
                                    </td>
                                    <td>
                                        {{ $customer->email }}
                                    </td>
                                    <td>{{ date('Y-m-d', strtotime($customer->created_at)) }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3">{{ translate('messages.no_data_found') }}</td>
                            </tr>
                        @endif
                    </tbody>

                </table>
            </div>
            <!-- End Table -->
            <!-- Footer -->
            {{-- <div class="card-footer">
                <!-- Pagination -->
                <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                    <div class="col-sm-auto">
                        <div class="d-flex justify-content-center justify-content-sm-end">
                            <!-- Pagination -->
                            $customer->links() !!}
                        </div>
                    </div>
                </div>
                <!-- End Pagination -->
            </div> --}}
            <!-- End Footer -->
        </div>
        <!-- End Card -->
    </div>
@endsection
@push('script_2')
    <script type="text/javascript">
        $('#search-form').on('submit', function() {
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{ url('admin/customer/subscriber-search') }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#set-rows').html(data.view);
                    $('.card-footer').hide();
                },
                complete: function() {
                    $('#loading').hide();
                },
            });
        });
    </script>
@endpush
