<style>
    #printableArea *:not(input, a){
        color: black;
    }
</style>
<div class="content container-fluid">
        <div class="row" id="printableArea" style="font-family: emoji;">
            <div class="col-md-12">
                <center>
                    <input type="button" class="btn btn-primary non-printable" onclick="printDiv('printableArea')"
                           value="Proceed, If thermal printer is ready."/>
                    <a href="{{url()->previous()}}" class="btn btn-danger non-printable">{{translate('messages.back')}}</a>
                </center>
                <hr class="non-printable">
            </div>
            <div class="col-5">
                @if ($order->store)
                <div class="text-center pt-4 mb-3">
                    <h2 style="line-height: 1">{{$order->store->name}}</h2>
                    <h5 style="font-size: 20px;font-weight: lighter;line-height: 1">
                        {{$order->store->address}}
                    </h5>
                    <h5 style="font-size: 16px;font-weight: lighter;line-height: 1">
                        {{translate('messages.phone')}} : {{$order->store->phone}}
                    </h5>
                </div>                    
                

                <span>---------------------------------------------------------------------------------</span>
                @endif
                <div class="row mt-3">
                    <div class="col-6">
                        <h5>{{translate('order_id')}} : {{$order['id']}}</h5>
                    </div>
                    <div class="col-6">
                        <h5 style="font-weight: lighter">
                            {{date('d/M/Y '.config('timeformat'),strtotime($order['created_at']))}}
                        </h5>
                    </div>
                    @if ($order->order_type=='parcel')
                    <div class="col-12">
                        @php($address=json_decode($order->delivery_address,true))
                        <h5><u>{{translate('messages.sender')}} {{translate('messages.info')}}</u></h5>
                        <span>
                            {{translate('messages.sender')}} {{translate('messages.name')}} : {{isset($address)?$address['contact_person_name']:$order->address['f_name'].' '.$order->customer['l_name']}}
                        </span><br>
                        <span>
                            {{translate('messages.phone')}} : {{isset($address)?$address['contact_person_number']:$order->customer['phone']}}
                        </span><br>
                        <span class="text-break">
                            {{translate('messages.address')}} : {{isset($address)?$address['address']:''}}
                        </span>
                        <br>
                        <br>
                        @php($address=$order->receiver_details)
                        <h5><u>{{translate('messages.receiver')}} {{translate('messages.info')}}</u></h5>
                        <span>
                            {{translate('messages.receiver')}} {{translate('messages.name')}} : {{isset($address)?$address['contact_person_name']:$order->address['f_name'].' '.$order->customer['l_name']}}
                        </span><br>
                        <span>
                            {{translate('messages.phone')}} : {{isset($address)?$address['contact_person_number']:$order->customer['phone']}}
                        </span><br>
                        <span class="text-break">
                            {{translate('messages.address')}} : {{isset($address)?$address['address']:''}}
                        </span>
                    </div>
                    @else
                     <div class="col-12">
                         @php($address = json_decode($order->delivery_address, true))
                         @if(!empty($address))
                        <h5>
                            {{translate('messages.contact_person_name')}} : {{isset($address['contact_person_name'])?$address['contact_person_name']:''}}
                        </h5>
                        <h5>
                            {{translate('messages.phone')}} : {{isset($address['contact_person_number'])? $address['contact_person_number'] : ''}}
                        </h5>
                        <h5>
                            {{translate('messages.Floor')}} : {{isset($address['floor'])? $address['floor'] : ''}}
                        </h5>
                        <h5>
                            {{translate('messages.Road')}} : {{isset($address['road'])? $address['road'] : ''}}
                        </h5>
                        <h5>
                            {{translate('messages.House')}} : {{isset($address['house'])? $address['house'] : ''}}
                        </h5>
                        @endif
                        <h5 class="text-break">
                            {{translate('messages.address')}} : {{isset($order->delivery_address)?json_decode($order->delivery_address, true)['address']:''}}
                        </h5>
                    </div>                       
                    @endif

                </div>
                <h5 class="text-uppercase"></h5>
                <span>---------------------------------------------------------------------------------</span>
                <table class="table table-bordered mt-3" style="width: 98%; color:#000000">
                    <thead>
                    <tr>
                        <th style="width: 10%">{{translate('messages.qty')}}</th>
                        <th class="">{{translate('DESC')}}</th>
                        <th class="">{{translate('messages.price')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if ($order->order_type == 'parcel')
                        <tr>
                            <td>1</td>
                            <td>{{translate('messages.delivery_charge')}}</td>
                            <td>{{\App\CentralLogics\Helpers::format_currency($order->delivery_charge)}}</td>
                        </tr>
                    @else
                        @php($sub_total=0)
                        @php($total_tax=0)
                        @php($total_dis_on_pro=0)
                        @php($add_ons_cost=0)
                        @foreach($order->details as $detail)
                           
                            @php($item=json_decode($detail->item_details, true))
                                <tr>
                                    <td class="">
                                        {{$detail['quantity']}}
                                    </td>
                                    <td class="text-break">
                                        {{$item['name']}} <br>
                                        @if(count(json_decode($detail['variation'],true))>0)
                                            <strong><u>Variation : </u></strong>
                                            @foreach(json_decode($detail['variation'],true)[0] as $key1 =>$variation)
                                                @if ($key1 != 'stock')
                                                    <div class="font-size-sm text-body">
                                                        <span>{{$key1}} :  </span>
                                                        <span class="font-weight-bold">{{$key1=='price'?\App\CentralLogics\Helpers::format_currency($variation):$variation}}</span>
                                                    </div>                                                
                                                @endif

                                            @endforeach
                                        @else
                                        <div class="font-size-sm text-body">
                                            <span>{{translate('messages.price')}} :  </span>
                                            <span class="font-weight-bold">{{\App\CentralLogics\Helpers::format_currency($detail->price)}}</span>
                                        </div>
                                        @endif

                                        @foreach(json_decode($detail['add_ons'],true) as $key2 =>$addon)
                                            @if($key2==0)<strong><u>{{translate('messages.addons')}} : </u></strong>@endif
                                            <div class="font-size-sm text-body">
                                                <span class="text-break">{{$addon['name']}} :  </span>
                                                <span class="font-weight-bold">
                                                    {{$addon['quantity']}} x {{\App\CentralLogics\Helpers::format_currency($addon['price'])}}
                                                </span>
                                            </div>
                                            @php($add_ons_cost+=$addon['price']*$addon['quantity'])
                                        @endforeach
                                    </td>
                                    <td style="width: 28%">
                                        @php($amount=($detail['price'])*$detail['quantity'])
                                        {{\App\CentralLogics\Helpers::format_currency($amount)}}
                                    </td>
                                </tr>
                                @php($sub_total+=$amount)
                                @php($total_tax+=$detail['tax_amount']*$detail['quantity'])
                            
                            {{--@elseif($detail->campaign)
                                <tr>
                                    <td class="">
                                        {{$detail['quantity']}}
                                    </td>
                                    <td class="text-break">
                                        {{$detail->campaign['title']}} <br>
                                        @if(count(json_decode($detail['variation'],true))>0)
                                            <strong><u>Variation : </u></strong>
                                            @foreach(json_decode($detail['variation'],true)[0] as $key1 =>$variation)
                                                <div class="font-size-sm text-body">
                                                    <span>{{$key1}} :  </span>
                                                    <span class="font-weight-bold">{{$key1=='price'?\App\CentralLogics\Helpers::format_currency($variation):$variation}}</span>
                                                </div>
                                            @endforeach
                                        @else
                                        <div class="font-size-sm text-body">
                                            <span>{{translate('messages.price')}} :  </span>
                                            <span class="font-weight-bold">{{\App\CentralLogics\Helpers::format_currency($detail->price)}}</span>
                                        </div>
                                        @endif

                                        @foreach(json_decode($detail['add_ons'],true) as $key2 =>$addon)
                                            @if($key2==0)<strong><u>{{translate('messages.price')}} : </u></strong>@endif
                                            <div class="font-size-sm text-body">
                                                <span class="text-break">{{$addon['name']}} :  </span>
                                                <span class="font-weight-bold">
                                                    {{$addon['quantity']}} x {{\App\CentralLogics\Helpers::format_currency($addon['price'])}}
                                                </span>
                                            </div>
                                            @php($add_ons_cost+=$addon['price']*$addon['quantity'])
                                        @endforeach
                                    </td>
                                    <td style="width: 28%">
                                        @php($amount=($detail['price'])*$detail['quantity'])
                                        {{\App\CentralLogics\Helpers::format_currency($amount)}}
                                    </td>
                                </tr>
                                @php($sub_total+=$amount)
                                @php($total_tax+=$detail['tax_amount']*$detail['quantity'])
                            @endif--}}
                        @endforeach                        
                    @endif

                    </tbody>
                </table>
                <span>---------------------------------------------------------------------------------</span>
                <div class="row justify-content-md-end mb-3" style="width: 97%">
                    <div class="col-md-7 col-lg-7">
                        <dl class="row text-right">
                            @if ($order->order_type !='parcel')
                            <dt class="col-6">{{translate('item_price')}}:</dt>
                            <dd class="col-6">{{\App\CentralLogics\Helpers::format_currency($sub_total)}}</dd>
                            <dt class="col-6">{{translate('addon_cost')}}:</dt>
                            <dd class="col-6">
                                {{\App\CentralLogics\Helpers::format_currency($add_ons_cost)}}
                                <hr>
                            </dd>
                            <dt class="col-6">{{translate('messages.subtotal')}}:</dt>
                            <dd class="col-6">
                                {{\App\CentralLogics\Helpers::format_currency($sub_total+$add_ons_cost)}}</dd>
                            <dt class="col-6">{{translate('messages.discount')}}:</dt>
                            <dd class="col-6">
                                - {{\App\CentralLogics\Helpers::format_currency($order['store_discount_amount'])}}</dd>
                            <dt class="col-6">{{translate('messages.coupon_discount')}}:</dt>
                            <dd class="col-6">
                                - {{\App\CentralLogics\Helpers::format_currency($order['coupon_discount_amount'])}}</dd>
                            <dt class="col-6">{{translate('messages.vat/tax')}}:</dt>
                            <dd class="col-6">+ {{\App\CentralLogics\Helpers::format_currency($order['total_tax_amount'])}}</dd>
                            <dt class="col-6">{{translate('messages.delivery_charge')}}:</dt>
                            <dd class="col-6">
                                @php($del_c=$order['delivery_charge'])
                                {{\App\CentralLogics\Helpers::format_currency($del_c)}}
                                <hr>
                            </dd>                                
                            @endif


                            <dt class="col-6" style="font-size: 20px">{{translate('messages.total')}}:</dt>
                            <dd class="col-6" style="font-size: 20px">{{\App\CentralLogics\Helpers::format_currency($order->order_amount)}}</dd>
                        </dl>
                    </div>
                </div>
                <span>---------------------------------------------------------------------------------</span>
                <h5 class="text-center pt-3">
                    """{{translate('THANK YOU')}}"""
                </h5>
                <span>---------------------------------------------------------------------------------</span>
            </div>
        </div>
    </div>