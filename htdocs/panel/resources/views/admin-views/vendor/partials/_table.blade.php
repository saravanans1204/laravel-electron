@foreach($stores as $key=>$store)
<tr>
    <td>{{$key+1}}</td>
    <td>
        <div style="height: 60px; width: 60px; overflow-x: hidden;overflow-y: hidden">
            <a href="{{route('admin.vendor.view', $store->id)}}" alt="view store">
            <img width="60" style="border-radius: 50%; height:100%;"
                    onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                    src="{{asset('storage/app/public/store')}}/{{$store['logo']}}"></a>
        </div>
    </td>
    <td>
        <a href="{{route('admin.vendor.view', $store->id)}}" alt="view store">
            <span class="d-block font-size-sm text-body">
                {{Str::limit($store->name,20,'...')}}<br>
                {{translate('messages.id')}}:{{$store->id}}
            </span>
        </a>
    </td>
    <td>
        <span class="d-block font-size-sm text-body">
            {{Str::limit($store->module->module_name,20,'...')}}
        </span>
    </td>
    <td>
        <span class="d-block font-size-sm text-body">
            {{Str::limit($store->vendor->f_name.' '.$store->vendor->l_name,20,'...')}}
        </span>
    </td>
    <td>
        {{$store->zone?$store->zone->name:translate('messages.zone').' '.translate('messages.deleted')}}
        {{--<span class="d-block font-size-sm">{{$banner['image']}}</span>--}}
    </td>
    <td>
        {{$store['phone']}}
    </td>
    <td>
        <label class="toggle-switch toggle-switch-sm" for="featuredCheckbox{{$store->id}}">
            <input type="checkbox" onclick="location.href='{{route('admin.vendor.featured',[$store->id,$store->featured?0:1])}}'" class="toggle-switch-input" id="featuredCheckbox{{$store->id}}" {{$store->featured?'checked':''}}>
            <span class="toggle-switch-label">
                <span class="toggle-switch-indicator"></span>
            </span>
        </label>
    </td>

    <td>
        @if(isset($store->vendor->status))
            @if($store->vendor->status)
            <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox{{$store->id}}">
                <input type="checkbox" onclick="status_change_alert('{{route('admin.vendor.status',[$store->id,$store->status?0:1])}}', '{{translate('messages.you_want_to_change_this_store_status')}}', event)" class="toggle-switch-input" id="stocksCheckbox{{$store->id}}" {{$store->status?'checked':''}}>
                <span class="toggle-switch-label">
                    <span class="toggle-switch-indicator"></span>
                </span>
            </label>
            @else
            <span class="badge badge-soft-danger">{{translate('messages.denied')}}</span>
            @endif
        @else
            <span class="badge badge-soft-danger">{{translate('messages.pending')}}</span>
        @endif
    </td>
    
    <td>
        <a class="btn btn-sm btn-white"
            href="{{route('admin.vendor.view',[$store['id']])}}" title="{{translate('messages.view')}} {{translate('messages.store')}}"><i class="tio-visible text-success"></i>
        </a>
        <a class="btn btn-sm btn-white"
            href="{{route('admin.vendor.edit',[$store['id']])}}" title="{{translate('messages.edit')}} {{translate('messages.store')}}"><i class="tio-edit text-primary"></i>
        </a>
        <a class="btn btn-sm btn-white" href="javascript:"
        onclick="form_alert('vendor-{{$store['id']}}','{{translate('messages.You want to remove this store')}}')" title="{{translate('messages.delete')}} {{translate('messages.store')}}"><i class="tio-delete-outlined text-danger"></i>
        </a>
        <form action="{{route('admin.vendor.delete',[$store['id']])}}" method="post" id="vendor-{{$store['id']}}">
            @csrf @method('delete')
        </form>
    </td>
</tr>
@endforeach