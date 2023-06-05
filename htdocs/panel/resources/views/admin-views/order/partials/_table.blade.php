@foreach($orders as $key=>$order)

<tr class="status-{{$order['order_status']}} class-all">
    <td class="">
        {{$key+1}}
    </td>
    <td class="table-column-pl-0">
        <a href="{{route($parcel_order?'admin.parcel.order.details':'admin.order.details',['id'=>$order['id']])}}">{{$order['id']}}</a>
    </td>
    <td>{{date('d M Y',strtotime($order['created_at']))}}</td>
    <td>
        @if($order->customer)
            <a class="text-body text-capitalize"
                href="{{route('admin.customer.view',[$order['user_id']])}}">{{$order->customer['f_name'].' '.$order->customer['l_name']}}</a>
        @else
            <label class="badge badge-danger">{{translate('messages.invalid')}} {{translate('messages.customer')}} {{translate('messages.data')}}</label>
        @endif
    </td>
    <td>
        @if ($parcel_order)
            <label class="badge badge-soft-primary">{{Str::limit($order->parcel_category?$order->parcel_category->name:translate('messages.not_found'),20,'...')}}</label>
        @elseif ($order->store)
            <label class="badge badge-soft-primary"><a href="{{route('admin.vendor.view', $order->store_id)}}" alt="view store">{{Str::limit($order->store?$order->store->name:translate('messages.store deleted!'),20,'...')}}</a></label>
        @else
            <label class="badge badge-soft-danger">{{Str::limit(translate('messages.not_found'),20,'...')}}</label>
        @endif
    </td>
    <td>
        @if($order->payment_status=='paid')
            <span class="badge badge-soft-success">
                <span class="legend-indicator bg-success"></span>{{translate('messages.paid')}}
            </span>
        @else
            <span class="badge badge-soft-danger">
                <span class="legend-indicator bg-danger"></span>{{translate('messages.unpaid')}}
            </span>
        @endif
    </td>
    <td>{{\App\CentralLogics\Helpers::format_currency($order['order_amount'])}}</td>
    <td class="text-capitalize">
        @if($order['order_status']=='pending')
            <span class="badge badge-soft-info ml-2 ml-sm-3">
                <span class="legend-indicator bg-info"></span>{{translate('messages.pending')}}
            </span>
        @elseif($order['order_status']=='confirmed')
            <span class="badge badge-soft-info ml-2 ml-sm-3">
                <span class="legend-indicator bg-info"></span>{{translate('messages.confirmed')}}
            </span>
        @elseif($order['order_status']=='processing')
            <span class="badge badge-soft-warning ml-2 ml-sm-3">
                <span class="legend-indicator bg-warning"></span>{{translate('messages.processing')}}
            </span>
        @elseif($order['order_status']=='picked_up')
            <span class="badge badge-soft-warning ml-2 ml-sm-3">
                <span class="legend-indicator bg-warning"></span>{{translate('messages.out_for_delivery')}}
            </span>
        @elseif($order['order_status']=='delivered')
            <span class="badge badge-soft-success ml-2 ml-sm-3">
                <span class="legend-indicator bg-success"></span>{{translate('messages.delivered')}}
            </span>
        @elseif($order['order_status']=='failed')
            <span class="badge badge-soft-danger ml-2 ml-sm-3">
                <span class="legend-indicator bg-danger text-capitalize"></span>{{translate('messages.payment')}}  {{translate('messages.failed')}}
            </span>
        @else
            <span class="badge badge-soft-danger ml-2 ml-sm-3">
                <span class="legend-indicator bg-danger"></span>{{str_replace('_',' ',$order['order_status'])}}
            </span>
        @endif
    </td>
    <td class="text-capitalize">
        @if($order['order_type']=='take_away')
            <span class="badge badge-soft-dark ml-2 ml-sm-3">
                <span class="legend-indicator bg-dark"></span>{{translate('messages.take_away')}}
            </span>
        @else
            <span class="badge badge-soft-success ml-2 ml-sm-3">
                <span class="legend-indicator bg-success"></span>{{translate('messages.delivery')}}
            </span>
        @endif
    </td>
    <td>
        <a class="btn btn-sm btn-white"
                    href="{{route('admin.order.details',['id'=>$order['id']])}}"><i
                        class="tio-visible"></i> {{translate('messages.view')}}</a>
    </td>
</tr>

@endforeach
