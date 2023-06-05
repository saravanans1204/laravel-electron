@extends('layouts.admin.app')

@section('title','Store Bulk Import')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{translate('messages.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page"><a
                        href="{{route('admin.vendor.list')}}">{{translate('messages.stores')}}</a>
                </li>
                <li class="breadcrumb-item">{{translate('messages.bulk_import')}} </li>
            </ol>
        </nav>
        <h1 class="text-capitalize">{{translate('messages.stores')}} {{translate('messages.bulk_import')}}</h1>
        <!-- Content Row -->
        <div class="row">
            <div class="col-12">
                <div class="jumbotron pt-1" style="background: white">
                    <h3>Instructions : </h3>
                    <p>1. Download the format file and fill it with proper data.</p>

                    <p>2. You can download the example file to understand how the data must be filled.</p>

                    <p>3. Once you have downloaded and filled the format file, upload it in the form below and
                        submit.Make sure the phone numbers and email addresses are unique.</p>

                    <p>4. After uploading stores you need to edit them and set stores's logo and cover.</p>

                    <p>5. You can get module id and  zone id from their list, please input the right ids.</p>

                    <p>6. For delivery time the format is "from-to type" for example: "30-40 min". Also you can use days or hours as type. Please be carefull about this format or leave this field empty.</p>

                    <p>7. You can upload your store images in store folder from gallery, and copy image`s path.</p>
                    
                    <p>8. Default password for store is 12345678.</p>

                </div>
            </div>

            <div class="col-md-12">
                <form class="product-form" action="{{route('admin.vendor.bulk-import')}}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="card mt-2 rest-part">
                        <div class="card-header">
                            <h4>Import Stores File</h4>
                            <a href="{{asset('public/assets/stores_bulk_format.xlsx')}}" download=""
                               class="btn btn-secondary">Download Format</a>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="file" name="products_file">
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="checkbox" class="form-check-input" id="exampleCheck1" onchange="stackfoodCheck()">
                                            <label name="stackfood" class="form-check-label" value="1" for="exampleCheck1">Exporting from stackfood</label>                                            
                                        </div>
                                    </div> -->
                                    <!-- <div class="col-12">
                                        <div class="form-group py-2" id="module">
                                            <label class="input-label">{{translate('messages.module')}}</label>
                                            <select name="module_id" class="form-control js-select2-custom"  data-placeholder="{{translate('messages.select')}} {{translate('messages.module')}}">
                                                    <option value="" selected disabled>{{translate('messages.select')}} {{translate('messages.module')}}</option>
                                                @foreach(\App\Models\Module::where('module_type','food')->get() as $module)
                                                    <option value="{{$module->id}}">{{$module->module_name}}</option>
                                                @endforeach
                                            </select>
                                            <small class="text-danger">{{translate('messages.module_change_warning')}}</small>
                                        </div>
                                    </div> -->
                                    <div class="col-12 pt-2 mt-2">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script_2')
<!-- <script>
    stackfoodCheck();
    function stackfoodCheck()
    {
        if($('#exampleCheck1').is(':checked'))
        {
            $('#module').show();
            $('input[name="module_id"]').attr("required", true);
        }
        else
        {
            $('#module').hide();
            $('input[name="module_id"]').attr("required", false);
        }  
    }
</script> -->
@endpush
