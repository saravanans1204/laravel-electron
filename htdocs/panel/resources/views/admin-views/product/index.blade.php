@extends('layouts.admin.app')

@section('title',translate('messages.add_new_item'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('public/assets/admin/css/tags-input.min.css')}}" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-add-circle-outlined"></i> {{translate('messages.add')}} {{translate('messages.new')}} {{translate('messages.item')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="javascript:" method="post" id="item_form"
                      enctype="multipart/form-data">
                    @csrf
                    @php($language=\App\Models\BusinessSetting::where('key','language')->first())
                    @php($language = $language->value ?? null)
                    @php($default_lang = 'bn')
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
                            <div class="card p-4 {{$lang != $default_lang ? 'd-none':''}} lang_form" id="{{$lang}}-form">
                                <div class="form-group">
                                    <label class="input-label" for="{{$lang}}_name">{{translate('messages.name')}} ({{strtoupper($lang)}})</label>
                                    <input type="text" name="name[]" id="{{$lang}}_name" class="form-control" placeholder="{{translate('messages.new_item')}}" {{$lang == $default_lang? 'required':''}} oninvalid="document.getElementById('en-link').click()">
                                </div>
                                <input type="hidden" name="lang[]" value="{{$lang}}">
                                <div class="form-group pt-4">
                                    <label class="input-label" for="exampleFormControlInput1">{{translate('messages.short')}} {{translate('messages.description')}} ({{strtoupper($lang)}})</label>
                                    <textarea type="text" name="description[]" class="form-control ckeditor"></textarea>
                                </div>
                            </div>
                        @endforeach
                    @else
                    <div class="card p-4" id="{{$default_lang}}-form">
                        <div class="form-group">
                            <label class="input-label" for="exampleFormControlInput1">{{translate('messages.name')}} (EN)</label>
                            <input type="text" name="name[]" class="form-control" placeholder="{{translate('messages.new_item')}}" required>
                        </div>
                        <input type="hidden" name="lang[]" value="en">
                        <div class="form-group pt-4">
                            <label class="input-label" for="exampleFormControlInput1">{{translate('messages.short')}} {{translate('messages.description')}}</label>
                            <textarea type="text" name="description[]" class="form-control ckeditor"></textarea>
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="input-label">{{translate('messages.module')}}</label>
                                <select name="module_id" required class="form-control js-select2-custom"  data-placeholder="{{translate('messages.select')}} {{translate('messages.module')}}" onchange="modulChange(this.value)">
                                        <option value="" selected disabled>{{translate('messages.select')}} {{translate('messages.module')}}</option>
                                    @foreach(\App\Models\Module::notParcel()->get() as $module)
                                        <option value="{{$module->id}}" >{{$module->module_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="input-label" for="store_id">{{translate('messages.store')}}<span
                                        class="input-label-secondary"></span></label>
                                <select name="store_id" data-placeholder="{{translate('messages.select')}} {{translate('messages.store')}}" id="store_id" class="js-data-example-ajax form-control" onchange="getRestaurantData('{{url('/')}}/admin/vendor/get-addons?data[]=0&store_id=',this.value,'add_on')" oninvalid="this.setCustomValidity('{{translate('messages.please_select_store')}}')">
                                                        
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 col-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{translate('messages.price')}}</label>
                                <input type="number" min="0" max="999999999999.99" step="0.01" value="1" name="price" class="form-control"
                                       placeholder="Ex : 100" required>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{translate('messages.discount')}} {{translate('messages.type')}}</label>
                                <select name="discount_type" class="form-control js-select2-custom">
                                    <option value="percent">{{translate('messages.percent')}}</option>
                                    <option value="amount">{{translate('messages.amount')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{translate('messages.discount')}}</label>
                                <input type="number" min="0" max="9999999999999999999999" value="0" name="discount" class="form-control"
                                       placeholder="Ex : 100" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6" id="unit_input">
                            <div class="form-group">
                                <label class="input-label text-capitalize" for="unit">{{translate('messages.unit')}}</label>
                                <select name="unit" class="form-control js-select2-custom">
                                    @foreach (\App\Models\Unit::all() as $unit)
                                        <option value="{{$unit->id}}">{{$unit->unit}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group" id="veg_input">
                                <label class="input-label" for="exampleFormControlInput1">{{translate('messages.item_type')}}</label>
                                <select name="veg" class="form-control js-select2-custom" required>
                                    <option value="0">{{translate('messages.non_veg')}}</option>
                                    <option value="1">{{translate('messages.veg')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="input-label" for="category_id">{{translate('messages.category')}}<span
                                        class="input-label-secondary">*</span></label>
                                <select name="category_id" class="js-data-example-ajax form-control" id="category_id" onchange="categoryChange(this.value)">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="input-label" for="sub-categories">{{translate('messages.sub_category')}}<span
                                        class="input-label-secondary" title="{{translate('messages.category_required_warning')}}"><img src="{{asset('/public/assets/admin/img/info-circle.svg')}}" alt="{{translate('messages.category_required_warning')}}"></span></label>
                                <select name="sub_category_id" class="js-data-example-ajax form-control" id="sub-categories">

                                </select>
                            </div>
                        </div>
                        
                        {{--<div class="col-md-4 col-6">
                            <div class="form-group">
                                <label class="input-label" for="sub-sub-categories">Sub Sub Category<span
                                        class="input-label-secondary"></span></label>
                                <select name="sub_sub_category_id" id="sub-sub-categories"
                                        class="form-control js-select2-custom">

                                </select>
                            </div>
                        </div>--}}
                    </div>

                    <div class="row" style="border: 1px solid #80808045; border-radius: 10px;padding-top: 10px;margin: 1px">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlSelect1">{{translate('messages.attribute')}}<span
                                        class="input-label-secondary"></span></label>
                                <select name="attribute_id[]" id="choice_attributes"
                                        class="form-control js-select2-custom"
                                        multiple="multiple">
                                    @foreach(\App\Models\Attribute::orderBy('name')->get() as $attribute)
                                        <option value="{{$attribute['id']}}">{{$attribute['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 mt-2 mb-2">
                            <div class="customer_choice_options" id="customer_choice_options">

                            </div>
                        </div>
                        <div class="col-md-12 mt-2 mb-2">
                            <div class="variant_combination" id="variant_combination">

                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-6" id="stock_input">
                            <div class="form-group">
                                <label class="input-label" for="total_stock">{{translate('messages.total_stock')}}</label>                                
                                <input type="number" class="form-control" name="current_stock" id="quantity">
                            </div>
                        </div>
                        <div class="col-sm-6" id="addon_input">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlSelect1">{{translate('messages.addon')}}<span
                                        class="input-label-secondary" title="{{translate('messages.addon')}}"><img src="{{asset('/public/assets/admin/img/info-circle.svg')}}" alt="{{translate('messages.store_required_warning')}}"></span></label>                                
                                <select name="addon_ids[]" class="form-control js-select2-custom" multiple="multiple" id="add_on">
                                   
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="time_input">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{translate('messages.available')}} {{translate('messages.time')}} {{translate('messages.starts')}}</label>
                                <input type="time" name="available_time_starts" class="form-control" id="available_time_starts"
                                       placeholder="Ex : 10:30 am">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{translate('messages.available')}} {{translate('messages.time')}} {{translate('messages.ends')}}</label>
                                <input type="time" name="available_time_ends" class="form-control"  id="available_time_ends" placeholder="5:45 pm"
                                       >
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="text-dark">{{translate('messages.item')}} {{translate('messages.thumbnail')}}</label><small style="color: red">* ( {{translate('messages.ratio')}} 1:1 )</small>
                        <div class="custom-file">
                            <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                   accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                            <label class="custom-file-label" for="customFileEg1">{{translate('messages.choose')}} {{translate('messages.file')}}</label>
                        </div>

                        <center style="display: none" id="image-viewer-section" class="pt-2">
                            <img style="height: 200px;border: 1px solid; border-radius: 10px;" id="viewer"
                                 src="{{asset('public/assets/admin/img/400x400/img2.jpg')}}" alt="banner image"/>
                        </center>
                    </div>
                    <div class="form-group">
                        <label class="input-label" for="exampleFormControlInput1">{{translate('messages.item')}} {{translate('messages.images')}}</label>
                        <div>
                            <div class="row" id="coba"></div>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary">{{translate('messages.submit')}}</button>
                </form>
            </div>
        </div>
    </div>

@endsection


@push('script_2')
    <script src="{{asset('public/assets/admin')}}/js/tags-input.min.js"></script>
    <script>
        function getRestaurantData(route, store_id , id) {
            $.get({
                url: route+store_id,
                dataType: 'json',
                success: function (data) {
                    $('#' + id).empty().append(data.options);
                },
            });
        }
        
        function getRequest(route, id) {
            $.get({
                url: route,
                dataType: 'json',
                success: function (data) {
                    $('#' + id).empty().append(data.options);
                },
            });
        }
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
    </script>

    <script>
        var module_id = 0;
        var parent_category_id = 0;
        var module_data = null;
        var stock = true;

        function modulChange(id)
        {
            $.get({
                url: "{{url('/')}}/admin/module/"+id,
                dataType: 'json',
                success: function (data) {
                    module_data = data.data;
                    stock = module_data.stock;
                    if(stock)
                    {
                        $('#stock_input').show();
                    }
                    else
                    {
                        $('#stock_input').hide();
                    }
                    if(module_data.add_on)
                    {
                        $('#addon_input').show();
                    }
                    else{
                        $('#addon_input').hide();
                    }

                    if(module_data.item_available_time)
                    {
                        $('#time_input').show();
                    }
                    else{
                        $('#time_input').hide();
                    }

                    if(module_data.veg_non_veg)
                    {
                        $('#veg_input').show();
                    }
                    else{
                        $('#veg_input').hide();
                    }
                    if(module_data.unit)
                    {
                        $('#unit_input').show();
                    }
                    else{
                        $('#unit_input').hide();
                    }
                    combination_update();
                },
            });
            module_id = id;
        }

        function categoryChange(id)
        {
            parent_category_id = id;
            console.log(parent_category_id);
        }

        $(document).on('ready', function () {
            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
        $('#store_id').select2({
            ajax: {
                url: '{{url('/')}}/admin/vendor/get-stores',
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        module_id: module_id
                    };
                },
                processResults: function (data) {
                    return {
                    results: data
                    };
                },
                __port: function (params, success, failure) {
                    var $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });

        $('#category_id').select2({
            ajax: {
                url: '{{url('/')}}/admin/item/get-categories?parent_id=0',
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        module_id: module_id
                    };
                },
                processResults: function (data) {
                    return {
                    results: data
                    };
                },
                __port: function (params, success, failure) {
                    var $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });

        $('#sub-categories').select2({
            ajax: {
                url: '{{url('/')}}/admin/item/get-categories',
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        module_id: module_id,
                        parent_id: parent_category_id,
                        sub_category: true
                    };
                },
                processResults: function (data) {
                    return {
                    results: data
                    };
                },
                __port: function (params, success, failure) {
                    var $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });

        $('#choice_attributes').on('change', function () {
            if(module_id == 0)
            {
                toastr.error('{{translate("messages.select_a_module")}}', {
                    CloseButton: true,
                    ProgressBar: true
                });
                $(this).val("");
                return false;
            }
            $('#customer_choice_options').html(null);
            $.each($("#choice_attributes option:selected"), function () {
                if($(this).val().length > 50)
                {
                    toastr.error('{{translate('validation.max.string',['attribute'=>translate('messages.variation'),'max'=>'50'])}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                    return false;
                }
                add_more_customer_choice_option($(this).val(), $(this).text());
            });
        });

        function add_more_customer_choice_option(i, name) {
            let n = name;
            $('#customer_choice_options').append('<div class="row"><div class="col-md-3"><input type="hidden" name="choice_no[]" value="' + i + '"><input type="text" class="form-control" name="choice[]" value="' + n + '" placeholder="{{translate('messages.choice_title')}}" readonly></div><div class="col-lg-9"><input type="text" class="form-control" name="choice_options_' + i + '[]" placeholder="{{translate('messages.enter_choice_values')}}" data-role="tagsinput" onchange="combination_update()"></div></div>');
            $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
        }

        function combination_update() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{route('admin.item.variant-combination')}}",
                data: $('#item_form').serialize()+'&stock='+stock,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#loading').hide();
                    $('#variant_combination').html(data.view);
                    if (data.length < 1) {
                        $('input[name="current_stock"]').attr("readonly", false);
                    }
                }
            });
        }
    </script>

    <script>
        $('#item_form').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.item.store')}}',
                data: $('#item_form').serialize(),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#loading').hide();
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success("{{translate('messages.product_added_successfully')}}", {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setTimeout(function () {
                            location.href = "{{\Request::server('HTTP_REFERER')??route('admin.item.list')}}";
                        }, 2000);
                    }
                }
            });
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
                $("#from_part_2").removeClass('d-none');
            }
            else
            {
                $("#from_part_2").addClass('d-none');
            }
        })
    </script>
    <script src="{{asset('public/assets/admin/js/spartan-multi-image-picker.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'item_images[]',
                maxCount: 6,
                rowHeight: '120px',
                groupClassName: 'col-lg-2 col-md-4 col-sm-4 col-6',
                maxFileSize: '',
                placeholderImage: {
                    image: "{{asset('public/assets/admin/img/400x400/img2.jpg')}}",
                    width: '100%'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error("{{translate('messages.please_only_input_png_or_jpg_type_file')}}", {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error("{{translate('messages.file_size_too_big')}}", {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>
@endpush


