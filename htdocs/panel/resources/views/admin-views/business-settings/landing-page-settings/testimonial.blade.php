@extends('layouts.admin.app')

@section('title',translate('messages.landing_page_settings'))

@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/admin/css/croppie.css')}}" rel="stylesheet">
    <style>
        .flex-item{
            padding: 10px;
            flex: 20%;
        }

        /* Responsive layout - makes a one column-layout instead of a two-column layout */
        @media (max-width: 768px) {
            .flex-item{
                flex: 50%;
            }
        }

        @media (max-width: 480px) {
            .flex-item{
                flex: 100%;
            }
        }
    </style>
@endpush

@section('content')
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{translate('messages.dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{translate('messages.landing_page_settings')}}</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-header-title">{{translate('messages.landing_page_settings')}}</h1>
        <!-- Nav Scroller -->
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            <!-- Nav -->
            <ul class="nav nav-tabs page-header-tabs">
                <li class="nav-item">
                    <a class="nav-link"
                        href="{{ route('admin.business-settings.landing-page-settings', 'index') }}">{{ translate('messages.text') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                        href="{{ route('admin.business-settings.landing-page-settings', 'links') }}"
                        aria-disabled="true">{{ translate('messages.button_links') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                        href="{{ route('admin.business-settings.landing-page-settings', 'speciality') }}"
                        aria-disabled="true">{{ translate('messages.speciality') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active"
                        href="{{ route('admin.business-settings.landing-page-settings', 'testimonial') }}"
                        aria-disabled="true">{{ translate('messages.testimonial') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                        href="{{ route('admin.business-settings.landing-page-settings', 'feature') }}"
                        aria-disabled="true">{{ translate('messages.feature') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                        href="{{ route('admin.business-settings.landing-page-settings', 'image') }}"
                        aria-disabled="true">{{ translate('messages.image') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                        href="{{ route('admin.business-settings.landing-page-settings', 'background-change') }}"
                        aria-disabled="true">{{ translate('messages.background_color') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                        href="{{ route('admin.business-settings.landing-page-settings', 'web-app') }}"
                        aria-disabled="true">{{ translate('messages.web_app') }}</a>
                </li>
            </ul>
            <!-- End Nav -->
        </div>
        <!-- End Nav Scroller -->
    </div>
        <!-- End Page Header -->
    <!-- Page Heading -->

    <div class="card my-2">
        <div class="card-body">
            <form action="{{route('admin.business-settings.landing-page-settings', 'testimonial')}}" method="POST" enctype="multipart/form-data">
                @php($testimonial = \App\Models\BusinessSetting::where(['key'=>'testimonial'])->first())
                @php($testimonial = isset($testimonial->value)?json_decode($testimonial->value, true):null)

                @csrf

                <div class="form-group">
                    <label class="input-label" for="reviewer_name">{{translate('messages.reviewer')}}</label>
                    <input type="text" placeholder="{{translate('messages.reviewer_name')}}" id="reviewer_name"  name="reviewer_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="input-label" for="reviewer_designation">{{translate('messages.designation')}}</label>
                    <input type="text" placeholder="{{translate('messages.reviewer_designation')}}" id="reviewer_designation"  name="reviewer_designation" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="input-label" for="review">{{translate('messages.review')}}</label>
                    <textarea type="text" id="review" placeholder="{{translate('messages.review')}}"  name="review" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label class="input-label" >{{translate('messages.image')}}<small style="color: red">* ( {{translate('messages.size')}}: 140 X 140 px )</small></label>
                    <div class="custom-file">
                        <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                        <label class="custom-file-label" for="customFileEg1">{{translate('messages.choose')}} {{translate('messages.file')}}</label>
                    </div>

                    <center style="display: none" id="image-viewer-section" class="pt-2">
                        <img style="height: 200px;border: 1px solid; border-radius: 10px;" id="viewer"
                                src="{{asset('public/assets/admin/img/400x400/img2.jpg')}}" alt=""/>
                    </center>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-success" value="{{translate('messages.submit')}}">
                </div>
            </form>
            <div class="col-12">
                <table class="table table-borderless table-thead-bordered table-align-middle card-table">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 10%">#</th>
                            <th scope="col" style="width: 25%">{{translate('messages.reviewer')}}</th>
                            <th scope="col" style="width: 15%">{{translate('messages.designation')}}</th>
                            <th scope="col" style="width: 40%">{{translate('messages.review')}}</th>
                            <th scope="col" style="width: 10%">{{translate('messages.action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($testimonial)
                        @foreach ($testimonial as $key=>$sp)
                            <tr>
                                <td scope="row">{{$key + 1}}</td>
                                <td>
                                    <div class="media align-items-center">
                                        <img class="avatar avatar-lg mr-3" src="{{asset('public/assets/landing/image')}}/{{$sp['img']}}"
                                                onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'" alt="{{$sp['name']}}">
                                        <div class="media-body">
                                            <h5 class="text-hover-primary mb-0">{{$sp['name']}}</h5>
                                        </div>
                                    </div>
                                </td>
                                <td>{{$sp['position']}}</td>
                                <td style="max-width:150px;">
                                    <p class="text-justify w-100">{{$sp['detail']}}</p>
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-white" href="javascript:"
                                        onclick="form_alert('sp-{{$key}}','{{translate('messages.Want_to_delete_this_item')}}')" title="{{translate('messages.delete')}}"><i class="tio-delete-outlined"></i>
                                    </a>
                                    <form action="{{route('admin.business-settings.landing-page-settings-delete',['tab'=>'testimonial', 'key'=>$key])}}"
                                            method="post" id="sp-{{$key}}">
                                        @csrf @method('delete')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection

@push('script_2')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
            $('#image-viewer-section').show(1000);
        });

        $(document).on('ready', function () {

        });
    </script>
@endpush
