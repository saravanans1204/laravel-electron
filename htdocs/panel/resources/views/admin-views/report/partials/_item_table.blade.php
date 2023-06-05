@foreach($items as $key=>$item)
    <tr>
        <td>{{$key+1}}</td>
        <td>
            <a class="media align-items-center" href="{{route('admin.item.view',[$item['id']])}}">
                <img class="avatar avatar-lg mr-3" src="{{asset('storage/app/public/product')}}/{{$item['image']}}" 
                        onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'" alt="{{$item->name}} image">
                <div class="media-body">
                    <h5 class="text-hover-primary mb-0">{{$item['name']}}</h5>
                </div>
            </a>
        </td>
        <td>
        {{Str::limit($item->restaurant->name,25,'...')}}
        </td>
        <td>{{$item->restaurant->zone->name}}</td>
        <td>
            {{$item->order_count}}
        </td>
        <td>
            <a class="btn btn-sm btn-white"
                href="{{route('admin.item.edit',[$item['id']])}}" title="{{translate('messages.edit')}} {{translate('messages.item')}}"><i class="tio-edit"></i>
            </a>
        </td>
    </tr>
@endforeach
