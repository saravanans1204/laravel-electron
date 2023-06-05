@extends('layouts.admin.app')
@section('title', translate('messages.landing_page_settings'))
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{ asset('public/assets/admin/css/croppie.css') }}" rel="stylesheet">
    <style>
        .flex-item {
            padding: 10px;
            flex: 20%;
        }

        /* Responsive layout - makes a one column-layout instead of a two-column layout */
        @media (max-width: 768px) {
            .flex-item {
                flex: 50%;
            }
        }

        @media (max-width: 480px) {
            .flex-item {
                flex: 100%;
            }
        }

    </style>
@endpush
@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ translate('messages.dashboard') }}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{ translate('messages.social') }}</li>
            </ol>
        </nav>
        <!-- Page Heading -->
        <div class="card my-2">
            <div class="card-body">
                <form style="text-align: left;" action="javascript:">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="name" class="">{{ translate('messages.name') }}</label>
                                <select class="form-control" name="name" id="name" style="width: 100%">
                                    <option>---{{ translate('messages.select') }}---</option>
                                    <option value="instagram">{{ translate('messages.Instagram') }}</option>
                                    <option value="facebook">{{ translate('messages.Facebook') }}</option>
                                    <option value="twitter">{{ translate('messages.Twitter') }}</option>
                                    <option value="linkedin">{{ translate('messages.LinkedIn') }}</option>
                                    <option value="pinterest">{{ translate('messages.Pinterest') }}</option>
                                </select>
                            </div>
                            <div class="col-md-12 mt-2">
                                <input type="hidden" id="id">
                                <label for="link"
                                    class="{{ Session::get('direction') === 'rtl' ? 'mr-1' : '' }}">{{ translate('messages.social_media_link') }}</label>
                                <input type="text" name="link" class="form-control" id="link"
                                    placeholder="{{ translate('messages.social_media_link') }}" required>
                            </div>
                            <div class="col-md-12">
                                <input type="hidden" id="id">
                            </div>

                        </div>
                    </div>
                    <div class="card-footer">
                        <button id="add" class="btn btn-primary" style="color: white">{{ translate('messages.save') }}</button>
                        <a id="update" class="btn btn-primary" href="javascript:"
                            style="display: none; color: #fff;">{{ translate('messages.update') }}</a>
                    </div>
                </form>
                <div class="col-12">
                    <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                        <thead>
                            <tr>
                                <th scope="col">{{ translate('messages.sl') }}</th>
                                <th scope="col">{{ translate('messages.name') }}</th>
                                <th scope="col">{{ translate('messages.link') }}</th>
                                <th scope="col">{{ translate('messages.status') }}</th>
                                <th scope="col" style="width: 120px">{{ translate('messages.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script_2')
    <script>
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });

        fetch_social_media();

        function fetch_social_media() {

            $.ajax({
                url: "{{ route('admin.business-settings.social-media.fetch') }}",
                method: 'GET',
                success: function(data) {
                    if (data.length != 0) {
                        var html = '';
                        for (var count = 0; count < data.length; count++) {
                            html += '<tr>';
                            html += '<td class="column_name" data-column_name="sl" data-id="' + data[count].id +
                                '">' + (count + 1) + '</td>';
                            html += '<td class="column_name" data-column_name="name" data-id="' + data[count]
                                .id + '">' + data[count].name + '</td>';
                            html += '<td class="column_name" data-column_name="slug" data-id="' + data[count]
                                .id + '">' + data[count].link + '</td>';
                            html += `<td class="column_name" data-column_name="status" data-id="${data[count].id}">
                            <label class="toggle-switch toggle-switch-sm" for="${data[count].id}">
                                    <input type="checkbox" class="toggle-switch-input status" id="${data[count].id}" ${data[count].status == 1 ? "checked" : ""}>
                                    <span class="toggle-switch-label">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>
                                </label>
                        </td>`;
                            // html += '<td><a type="button" class="btn btn-primary btn-xs edit" id="' + data[count].id + '"><i class="fa fa-edit text-white"></i></a> <a type="button" class="btn btn-danger btn-xs delete" id="' + data[count].id + '"><i class="fa fa-trash text-white"></i></a></td></tr>';
                            html += '<td><a type="button" class="btn btn-primary btn-xs edit" id="' + data[
                                count].id + '">Edit</a> </td></tr>';
                        }
                        $('tbody').html(html);
                    }
                }
            });
        }

        $('#add').on('click', function() {
            // $('#add').attr("disabled", true);
            var name = $('#name').val();
            var link = $('#link').val();
            if (name == "") {
                toastr.error('{{ translate('messages.social_media_required') }}.');
                return false;
            }
            if (link == "") {
                toastr.error('{{ translate('messages.social_media_required') }}.');
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('admin.business-settings.social-media.store') }}",
                method: 'POST',

                data: {
                    name: name,
                    link: link
                },
                success: function(response) {
                    if (response.error == 1) {
                        toastr.error('{{ translate('messages.social_media_exist') }}');
                    } else {
                        toastr.success('{{ translate('messages.social_media_inserted') }}.');
                    }
                    $('#name').val('');
                    $('#link').val('');
                    fetch_social_media();
                }
            });
        });
        $(document).on('click', '.edit', function() {
            $('#update').show();
            $('#add').hide();
            var id = $(this).attr("id");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('admin/business-settings/social-media') }}/" + id,
                method: 'GET',
                success: function(data) {
                    $(window).scrollTop(0);
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#link').val(data.link);
                    fetch_social_media()
                }
            });
        });

        $('#update').on('click', function() {
            $('#update').attr("disabled", true);
            var id = $('#id').val();
            var name = $('#name').val();
            var link = $('#link').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('admin/business-settings/social-media') }}/" + id,
                method: 'PUT',
                data: {
                    id: id,
                    name: name,
                    link: link,
                },
                success: function(data) {
                    $('#name').val('');
                    $('#link').val('');

                    toastr.success('{{ translate('messages.social_media_updated') }}');
                    $('#update').hide();
                    $('#add').show();
                    fetch_social_media();

                }
            });
            $('#save').hide();
        });
        $(document).on('click', '.delete', function() {
            var id = $(this).attr("id");
            if (confirm("{{ translate('messages.are_u_sure_want_to_delete') }}?")) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('admin/business-settings/social-media/destroy') }}/" + id,
                    method: 'POST',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        fetch_social_media();
                        toastr.success('{{ translate('messages.social_media_deleted') }}.');
                    }
                });
            }
        });

        $(document).on('change', '.status', function() {
            var id = $(this).attr("id");
            if ($(this).prop("checked") == true) {
                var status = 1;
            } else if ($(this).prop("checked") == false) {
                var status = 0;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('admin.business-settings.social-media.status-update') }}",
                method: 'get',
                data: {
                    id: id,
                    status: status
                },
                success: function() {
                    toastr.success('{{ translate('messages.status_updated') }}');
                }
            });
        });
    </script>
@endpush
