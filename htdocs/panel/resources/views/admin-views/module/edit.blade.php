@extends('layouts.admin.app')

@section('title',translate('messages.Update category'))

@push('css_or_js')
<link rel="stylesheet" href="{{asset('public/assets/admin/css/radio-image.css')}}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-edit"></i>{{translate('messages.update_module')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{route('admin.module.update',[$module['id']])}}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    @php($language=\App\Models\BusinessSetting::where('key','language')->first())
                    @php($language = $language->value ?? null)
                    @php($default_lang = 'en')
                    @if($language)
                        @php($default_lang = json_decode($language)[0])
                        <ul class="nav nav-tabs mb-4">
                            @foreach(json_decode($language) as $lang)
                                <li class="nav-item">
                                    <a class="nav-link lang_link {{$lang == $default_lang? 'active':''}}" href="#" id="{{$lang}}-link">{{\App\CentralLogics\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                                </li>
                            @endforeach
                        </ul>
                        @foreach(json_decode($language) as $lang)
                            <?php
                                if(count($module['translations'])){
                                    $translate = [];
                                    foreach($module['translations'] as $t)
                                    {
                                        if($t->locale == $lang && $t->key=="module_name"){
                                            $translate[$lang]['module_name'] = $t->value;
                                        }
                                    }
                                }
                            ?>
                            <div class="card card-body {{$lang != $default_lang ? 'd-none':''}} lang_form" id="{{$lang}}-form">
                                <div class="form-group" >
                                    <label class="input-label" for="exampleFormControlInput1">{{translate('messages.name')}} ({{strtoupper($lang)}})</label>
                                    <input type="text" name="module_name[]" class="form-control" maxlength="191" value="{{$lang==$default_lang?$module['module_name']:($translate[$lang]['module_name']??'')}}" {{$lang == $default_lang? 'required':''}} oninvalid="document.getElementById('en-link').click()">
                                </div>
                                <div class="form-group">
                                    <label class="input-label" for="module_type">{{translate('messages.description')}} ({{strtoupper($lang)}})</label>
                                    <textarea class="ckeditor form-control" name="description[]">{!! $lang==$default_lang?$module['description']:($translate[$lang]['description']??'') !!}</textarea>
                                </div>
                            </div>

                            <input type="hidden" name="lang[]" value="{{$lang}}">
                        @endforeach
                    @else
                        <div class="form-group">
                            <label class="input-label" for="exampleFormControlInput1">{{translate('messages.name')}}</label>
                            <input type="text" name="module_name" class="form-control" placeholder="{{translate('messages.new_category')}}" value="{{old('name')}}" required maxlength="191">
                        </div>
                        <div class="form-group">
                            <label class="input-label" for="module_type">{{translate('messages.description')}}</label>
                            <textarea class="ckeditor form-control" name="description">{!! $module->description !!}</textarea>
                        </div>
                        <input type="hidden" name="lang[]" value="{{$lang}}">
                    @endif
                    <div class="row mt-2">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="input-label" for="module_type">{{translate('messages.module_type')}}</label>
                                <select name="module_type" id="module_type" class="form-control text-capitalize" disabled>
                                    @foreach (config('module.module_type') as $key)
                                        <option value="{{$key}}" {{$key==$module->module_type?'selected':''}}>{{$key}}</option>
                                    @endforeach
                                </select>
                                <div class="card mt-1" id="module_des_card">
                                    <div class="card-body" id="module_description">{{config('module.'.$module->module_type)['description']}}</div>
                                </div>
                            </div>                       
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="input-label">{{ translate('Store can serve in') }} <small style="color: red"><span class="input-label-secondary"
                                        title="{{ translate('messages.module_all_zone_hint') }}">
                                        <img src="{{ asset('/public/assets/admin/img/info-circle.svg') }}"
                                            alt="{{ translate('messages.module_all_zone_hint') }}" style="height: 10px; width: 10px;">
                                </span> *</small></label>
                                
                                <div class="input-group input-group-md-down-break">
                                    <!-- Custom Radio -->
                                    <div class="form-control">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" value="1"
                                                name="all_zone_service" id="all_zone_service1" {{$module->all_zone_service == 1? 'checked': ''}}>
                                            <label class="custom-control-label" for="all_zone_service1">{{ translate('messages.All Zones') }}</label>
                                        </div>
                                    </div>
                                    <!-- End Custom Radio -->

                                    <!-- Custom Radio -->
                                    <div class="form-control">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" value="0"
                                                name="all_zone_service" id="all_zone_service2" {{$module->all_zone_service == 1? '': 'checked'}}>
                                            <label class="custom-control-label"
                                                for="all_zone_service2">{{ translate('One Zone') }}</label>
                                        </div>
                                    </div>
                                    <!-- End Custom Radio -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="module_theme" >
                        <label class="input-label" for="module_type">{{translate('messages.select_theme')}}</label>
                        <div class="row">
                            <div class='col-md-3 col-sm-6 col-12 text-center'>
                                <input type="radio" name="theme" require id="img1" class="d-none imgbgchk" value="1" {{$module->theme_id==1?'checked':''}}>
                                <label for="img1">
                                    <img class="img-thumbnail rounded" src="{{asset('public/assets/admin/img/Theme-1.png')}}" alt="Image 1">
                                </label>
                            </div>
                            <div class='col-md-3 col-sm-6 col-12 text-center'>
                                <input type="radio" name="theme" require id="img2" class="d-none imgbgchk" value="2" {{$module->theme_id==2?'checked':''}}>
                                <label for="img2">
                                    <img class="img-thumbnail rounded" src="{{asset('public/assets/admin/img/Theme-2.png')}}" alt="Image 2">
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{translate('messages.icon')}}</label><small style="color: red">* ( {{translate('messages.ratio')}} 1:1)</small>
                                <div class="custom-file">
                                    <input type="file" name="icon" id="customFileEg1" class="custom-file-input" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    <label class="custom-file-label" for="customFileEg1">{{translate('messages.choose')}} {{translate('messages.file')}}</label>
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom:0%;">
                                <center>
                                    <img style="width: 150px; height:150px; border: 1px solid; border-radius: 10px;" id="viewer" onerror="this.src='{{asset('public/assets/admin/img/400x400/img2.jpg')}}'" src="{{asset('storage/app/public/module/'.$module['icon'])}}" alt="image" />
                                </center>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{translate('messages.thumbnail')}}</label><small style="color: red">* ( {{translate('messages.ratio')}} 1:1)</small>
                                <div class="custom-file">
                                    <input type="file" name="thumbnail" id="customFileEg2" class="custom-file-input" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    <label class="custom-file-label" for="customFileEg2">{{translate('messages.choose')}} {{translate('messages.file')}}</label>
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom:0%;">
                                <center>
                                    <img style="width: 200px; height:200px; border: 1px solid; border-radius: 10px;" id="viewer2" onerror="this.src='{{asset('public/assets/admin/img/400x400/img2.jpg')}}'" src="{{asset('storage/app/public/module/'.$module['thumbnail'])}}" alt="image" />
                                </center>
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
    <script>
        function modulChange(id)
        {
            $.get({
                url: "{{url('/')}}/admin/module/type/?module_type="+id,
                dataType: 'json',
                success: function (data) {
                    if(data.data.description.length)
                    {
                        $('#module_des_card').show();
                        $('#module_description').html(data.data.description);                    
                    }
                    else
                    {
                        $('#module_des_card').hide();
                    }
                    if(id=='parcel')
                    {
                        $('#module_theme').hide();
                    }
                },
            });
        }

        function readURL(input, id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#'+id).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this,'viewer');
        });

        $("#customFileEg2").change(function () {
            readURL(this,'viewer2');
        });
    </script>
    <script>
        $(".lang_link").click(function(e){
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.substring(0, form_id.length - 5);
            console.log(lang);
            $("#"+lang+"-form").removeClass('d-none');
            if(lang == '{{$default_lang}}')
            {
                $(".from_part_2").removeClass('d-none');
            }
            else
            {
                $(".from_part_2").addClass('d-none');
            }
        });
    </script>
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            @if ($module->module_type=='parcel')
                $('#module_des_card').hide();
                $('#module_theme').hide();
            @endif
            $('.ckeditor').ckeditor();
        });
    </script>
@endpush
