<style>
    .nav-sub{
        background: #213A36!important;
    }
</style>
<div id="sidebarMain" class="d-none">
    <aside
        class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered">
        <div class="navbar-vertical-container">
            <div class="navbar-brand-wrapper justify-content-center" onclick="location.href='{{route('vendor.dashboard')}}'" style="cursor: pointer;font-weight: bold;font-size: 15px">
                <!-- Logo -->

                @php($store_data=\App\CentralLogics\Helpers::get_store_data())
                <a class="navbar-brand" href="{{route('vendor.dashboard')}}" aria-label="Front" style="padding-top: 0!important;padding-bottom: 0!important;">
                    <img class="navbar-brand-logo"
                         style="border-radius: 50%;height: 55px;width: 55px!important; border: 5px solid #80808012"
                         onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'"
                         src="{{asset('storage/app/public/store/'.$store_data->logo)}}"
                         alt="Logo">
                    <img class="navbar-brand-logo-mini"
                         style="border-radius: 50%;height: 55px;width: 55px!important; border: 5px solid #80808012"
                         onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'"
                         src="{{asset('storage/app/public/store/'.$store_data->logo)}}" alt="Logo">
                </a>
                {{\Illuminate\Support\Str::limit($store_data->name,15)}}
                <!-- End Logo -->

                <!-- Navbar Vertical Toggle -->
                <button type="button"
                        class="js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs btn-ghost-dark">
                    <i class="tio-clear tio-lg"></i>
                </button>
                <!-- End Navbar Vertical Toggle -->
            </div>

            <!-- Content -->
            <div class="navbar-vertical-content text-capitalize"  style="background-color: #213A36;">
                <ul class="navbar-nav navbar-nav-lg nav-tabs">
                    <!-- Dashboards -->
                    <li class="navbar-vertical-aside-has-menu {{Request::is('vendor-panel')?'show':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link"
                            href="{{route('vendor.dashboard')}}" title="{{translate('messages.dashboard')}}">
                            <i class="tio-home-vs-1-outlined nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                {{translate('messages.dashboard')}}
                            </span>
                        </a>
                    </li>
                    <!-- End Dashboards -->

                    @if(\App\CentralLogics\Helpers::employee_module_permission_check('order'))
                    <li class="nav-item">   
                        <small class="nav-subtitle" title="{{translate('messages.order')}} {{translate('messages.section')}}">{{translate('messages.order')}} {{translate('messages.section')}}</small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>

                    <!-- Order -->
                    <li class="navbar-vertical-aside-has-menu {{Request::is('vendor-panel/order*')?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                            title="{{translate('messages.orders')}}">
                            <i class="tio-shopping-cart nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                {{translate('messages.orders')}}
                            </span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                            style="display: {{Request::is('vendor-panel/order*')?'block':'none'}}">
                            <li class="nav-item {{Request::is('vendor-panel/order/list/pending')?'active':''}}">
                                <a class="nav-link " href="{{route('vendor.order.list',['pending'])}}" title="{{translate('messages.pending')}}({{translate('messages.take_away')}})">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">
                                        {{translate('messages.pending')}} {{(config('order_confirmation_model') == 'store' || \App\CentralLogics\Helpers::get_store_data()->self_delivery_system)?'':translate('messages.take_away')}}
                                            <span class="badge badge-soft-success badge-pill ml-1">
                                            @if(config('order_confirmation_model') == 'store' || \App\CentralLogics\Helpers::get_store_data()->self_delivery_system)
                                            {{\App\Models\Order::where(['order_status'=>'pending','store_id'=>\App\CentralLogics\Helpers::get_store_id()])->StoreOrder()->OrderScheduledIn(30)->count()}}
                                            @else
                                            {{\App\Models\Order::where(['order_status'=>'pending','store_id'=>\App\CentralLogics\Helpers::get_store_id(), 'order_type'=>'take_away'])->StoreOrder()->OrderScheduledIn(30)->count()}}
                                            @endif
                                        </span>
                                    </span>
                                </a>
                            </li>

                            <li class="nav-item {{Request::is('vendor-panel/order/list/confirmed')?'active':''}}">
                                <a class="nav-link " href="{{route('vendor.order.list',['confirmed'])}}" title="{{translate('messages.confirmed')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">
                                        {{translate('messages.confirmed')}}
                                            <span class="badge badge-soft-success badge-pill ml-1">
                                            {{\App\Models\Order::whereIn('order_status',['confirmed', 'accepted'])->StoreOrder()->whereNotNull('confirmed')->where('store_id', \App\CentralLogics\Helpers::get_store_id())->OrderScheduledIn(30)->count()}}
                                        </span>
                                    </span>
                                </a>
                            </li>

                            <li class="nav-item {{Request::is('vendor-panel/order/list/cooking')?'active':''}}">
                                <a class="nav-link" href="{{route('vendor.order.list',['cooking'])}}" title="{{translate('messages.cooking')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">
                                        {{translate('messages.cooking')}}
                                        <span class="badge badge-info badge-pill ml-1">
                                            {{\App\Models\Order::where(['order_status'=>'processing', 'store_id'=>\App\CentralLogics\Helpers::get_store_id()])->StoreOrder()->count()}}
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item {{Request::is('vendor-panel/order/list/ready_for_delivery')?'active':''}}">
                                <a class="nav-link" href="{{route('vendor.order.list',['ready_for_delivery'])}}" title="{{translate('messages.ready_for_delivery')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">
                                        {{translate('messages.ready_for_delivery')}}
                                        <span class="badge badge-info badge-pill ml-1">
                                            {{\App\Models\Order::where(['order_status'=>'handover', 'store_id'=>\App\CentralLogics\Helpers::get_store_id()])->StoreOrder()->count()}}
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item {{Request::is('vendor-panel/order/list/item_on_the_way')?'active':''}}">
                                <a class="nav-link" href="{{route('vendor.order.list',['item_on_the_way'])}}" title="{{translate('messages.items_on_the_way')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">
                                        {{translate('messages.item_on_the_way')}}
                                        <span class="badge badge-info badge-pill ml-1">
                                            {{\App\Models\Order::where(['order_status'=>'picked_up', 'store_id'=>\App\CentralLogics\Helpers::get_store_id()])->StoreOrder()->count()}}
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item {{Request::is('vendor-panel/order/list/delivered')?'active':''}}">
                                <a class="nav-link " href="{{route('vendor.order.list',['delivered'])}}" title="">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">
                                        {{translate('messages.delivered')}}
                                            <span class="badge badge-success badge-pill ml-1">
                                            {{\App\Models\Order::where(['order_status'=>'delivered','store_id'=>\App\CentralLogics\Helpers::get_store_id()])->StoreOrder()->count()}}
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item {{Request::is('vendor-panel/order/list/refunded')?'active':''}}">
                                <a class="nav-link " href="{{route('vendor.order.list',['refunded'])}}" title="">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">
                                        {{translate('messages.refunded')}}
                                            <span class="badge badge-soft-danger bg-light badge-pill ml-1">
                                            {{\App\Models\Order::Refunded()->where(['store_id'=>\App\CentralLogics\Helpers::get_store_id()])->StoreOrder()->count()}}
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item {{Request::is('vendor-panel/order/list/scheduled')?'active':''}}">
                                <a class="nav-link" href="{{route('vendor.order.list',['scheduled'])}}" title="{{translate('messages.scheduled')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">
                                        {{translate('messages.scheduled')}}
                                        <span class="badge badge-info badge-pill ml-1">
                                            {{\App\Models\Order::where('store_id',\App\CentralLogics\Helpers::get_store_id())->StoreOrder()->Scheduled()->where(function($q){
                                                if(config('order_confirmation_model') == 'store' || \App\CentralLogics\Helpers::get_store_data()->self_delivery_system)
                                                {
                                                    $q->whereNotIn('order_status',['failed','canceled', 'refund_requested', 'refunded']);
                                                }
                                                else
                                                {
                                                    $q->whereNotIn('order_status',['pending','failed','canceled', 'refund_requested', 'refunded'])->orWhere(function($query){
                                                        $query->where('order_status','pending')->where('order_type', 'take_away');
                                                    });
                                                }

                                            })->count()}}
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item {{Request::is('vendor-panel/order/list/all')?'active':''}}">
                                <a class="nav-link" href="{{route('vendor.order.list',['all'])}}" title="{{translate('messages.all')}} {{translate('messages.order')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">
                                        {{translate('messages.all')}}
                                        <span class="badge badge-info badge-pill ml-1">
                                            {{\App\Models\Order::where('store_id', \App\CentralLogics\Helpers::get_store_id())
                                                ->where(function($query){
                                                    return $query->whereNotIn('order_status',(config('order_confirmation_model') == 'store'|| \App\CentralLogics\Helpers::get_store_data()->self_delivery_system)?['failed','canceled', 'refund_requested', 'refunded']:['pending','failed','canceled', 'refund_requested', 'refunded'])
                                                    ->orWhere(function($query){
                                                        return $query->where('order_status','pending')->where('order_type', 'take_away');
                                                    });
                                            })->StoreOrder()->count()}}
                                        </span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- End Order -->
                    @endif
                    
                    @if(\App\CentralLogics\Helpers::employee_module_permission_check('pos'))
                    <li class="nav-item">
                        <small
                            class="nav-subtitle">{{translate('messages.pos')}} {{translate('messages.system')}}</small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>
                    
                    
                    <!-- POS -->
                    <li class="navbar-vertical-aside-has-menu {{Request::is('vendor-panel/pos/*')?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                        >
                            <i class="tio-shopping nav-icon"></i>
                            <span
                                class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{translate('messages.pos')}}</span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                            style="display: {{Request::is('vendor-panel/pos/*')?'block':'none'}}">
                            <li class="nav-item {{Request::is('vendor-panel/pos/')?'active':''}}">
                                <a class="nav-link " href="{{route('vendor.pos.index')}}"
                                    title="{{translate('messages.pos')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span
                                        class="text-truncate">{{translate('messages.pos')}}</span>
                                </a>
                            </li>
                            <li class="nav-item {{Request::is('vendor-panel/pos/orders')?'active':''}}">
                                <a class="nav-link " href="{{route('vendor.pos.orders')}}" title="{{translate('messages.orders')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{translate('messages.orders')}}
                                        <span class="badge badge-info badge-pill ml-1">
                                            {{\App\Models\Order::where('store_id',\App\CentralLogics\Helpers::get_store_id())->Pos()->count()}}
                                        </span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- End POS -->
                    @endif      
                    <li class="nav-item">
                        <small
                            class="nav-subtitle">{{translate('messages.item')}} {{translate('messages.management')}}</small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>

                    <!-- AddOn -->
                    @if(\App\CentralLogics\Helpers::employee_module_permission_check('addon'))
                    <li class="navbar-vertical-aside-has-menu {{Request::is('vendor-panel/addon*')?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link"
                            href="{{route('vendor.addon.add-new')}}" title="{{translate('messages.addons')}}"
                        >
                            <i class="tio-add-circle-outlined nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                {{translate('messages.addons')}}
                            </span>
                        </a>
                    </li>
                    @endif
                    <!-- End AddOn -->
                    @if(\App\CentralLogics\Helpers::employee_module_permission_check('item'))
                    <!-- Food -->
                    <li class="navbar-vertical-aside-has-menu {{Request::is('vendor-panel/item*')?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                        >
                            <i class="tio-premium-outlined nav-icon"></i>
                            <span
                                class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{translate('messages.items')}}</span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                            style="display: {{Request::is('vendor-panel/item*')?'block':'none'}}">
                            <li class="nav-item {{Request::is('vendor-panel/item/add-new')?'active':''}}">
                                <a class="nav-link " href="{{route('vendor.item.add-new')}}"
                                    title="add new item">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span
                                        class="text-truncate">{{translate('messages.add')}} {{translate('messages.new')}}</span>
                                </a>
                            </li>
                            <li class="nav-item {{Request::is('vendor-panel/item/list')?'active':''}}">
                                <a class="nav-link " href="{{route('vendor.item.list')}}" title="item list">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{translate('messages.list')}}</span>
                                </a>
                            </li>
                            @if(\App\CentralLogics\Helpers::get_store_data()->item_section)
                            <li class="nav-item {{Request::is('vendor-panel/item/bulk-import')?'active':''}}">
                                <a class="nav-link " href="{{route('vendor.item.bulk-import')}}"
                                    title="{{translate('messages.bulk_import')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate text-capitalize">{{translate('messages.bulk_import')}}</span>
                                </a>
                            </li>
                            <li class="nav-item {{Request::is('vendor-panel/item/bulk-export')?'active':''}}">
                                <a class="nav-link " href="{{route('vendor.item.bulk-export-index')}}"
                                    title="{{translate('messages.bukl_export')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate text-capitalize">{{translate('messages.bulk_export')}}</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    <!-- End Food -->
                    <li class="navbar-vertical-aside-has-menu {{Request::is('vendor-panel/category*')?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                            href="javascript:" title="{{translate('messages.category')}}"
                        >
                            <i class="tio-category nav-icon"></i>
                            <span
                                class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{translate('messages.categories')}}</span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                            style="display: {{Request::is('vendor-panel/category*')?'block':'none'}}">
                            <li class="nav-item {{Request::is('vendor-panel/category/list')?'active':''}}">
                                <a class="nav-link " href="{{route('vendor.category.add')}}"
                                    title="{{translate('messages.category')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{translate('messages.category')}}</span>
                                </a>
                            </li>

                            <li class="nav-item {{Request::is('vendor-panel/category/sub-category-list')?'active':''}}">
                                <a class="nav-link " href="{{route('vendor.category.add-sub-category')}}"
                                    title="{{translate('messages.sub_category')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{translate('messages.sub_category')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif

                    <!-- DeliveryMan -->
                    @if(\App\CentralLogics\Helpers::employee_module_permission_check('deliveryman'))
                        <li class="nav-item">
                            <small class="nav-subtitle"
                                   title="{{translate('messages.deliveryman')}} {{translate('messages.section')}}">{{translate('messages.deliveryman')}} {{translate('messages.section')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('vendor-panel/delivery-man/add')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('vendor.delivery-man.add')}}"
                               title="{{translate('messages.add_delivery_man')}}"
                            >
                                <i class="tio-running nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{translate('messages.add_delivery_man')}}
                                </span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('vendor-panel/delivery-man/list')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('vendor.delivery-man.list')}}"
                               title="{{translate('messages.deliveryman')}} {{translate('messages.list')}}"
                            >
                                <i class="tio-filter-list nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{translate('messages.deliverymen')}}
                                </span>
                            </a>
                        </li>

                        {{--<li class="navbar-vertical-aside-has-menu {{Request::is('vendor-panel/delivery-man/reviews/list')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('vendor.delivery-man.reviews.list')}}" title="{{translate('messages.reviews')}}"
                            >
                                <i class="tio-star-outlined nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{translate('messages.reviews')}}
                                </span>
                            </a>
                        </li>--}}
                    @endif
                <!-- End DeliveryMan -->

                    <li class="nav-item">
                        <small
                            class="nav-subtitle">{{translate('messages.marketing')}} {{translate('messages.section')}}</small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>
                    <!-- Campaign -->
                    @if(\App\CentralLogics\Helpers::employee_module_permission_check('campaign'))
                    <li class="navbar-vertical-aside-has-menu {{Request::is('vendor-panel/campaign*')?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:">
                            <i class="tio-image nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{translate('messages.campaign')}}</span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                            style="display: {{Request::is('vendor-panel/campaign*')?'block':'none'}}">
                            <li class="nav-item {{Request::is('vendor-panel/campaign/list')?'active':''}}">
                                <a class="nav-link " href="{{route('vendor.campaign.list')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{translate('messages.list')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    <!-- End Campaign -->

                    <!-- Business Section-->
                    <li class="nav-item">
                        <small class="nav-subtitle"
                                title="{{translate('messages.business')}} {{translate('messages.section')}}">{{translate('messages.business')}} {{translate('messages.section')}}</small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>

                    @if(\App\CentralLogics\Helpers::employee_module_permission_check('store_setup'))
                    <li class="nav-item {{Request::is('vendor-panel/business-settings/store-setup')?'active':''}}">
                        <a class="nav-link " href="{{route('vendor.business-settings.store-setup')}}" title="{{translate('messages.store')}} {{translate('messages.config')}}"
                        >
                            <span class="tio-settings nav-icon"></span>
                            <span
                                class="text-truncate">{{translate('messages.store')}} {{translate('messages.config')}}</span>
                        </a>
                    </li>
                    @endif

                    @if(\App\CentralLogics\Helpers::employee_module_permission_check('my_shop'))
                    <li class="navbar-vertical-aside-has-menu {{Request::is('vendor/store/*')?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link"
                            href="{{route('vendor.shop.view')}}"
                            title="{{translate('messages.my_shop')}}">
                            <i class="tio-home nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                {{translate('messages.my_shop')}}
                            </span>
                        </a>
                    </li>
                    @endif
                    @if(\App\CentralLogics\Helpers::employee_module_permission_check('bank_info'))
                    <!-- Business Settings -->
                    <li class="navbar-vertical-aside-has-menu {{Request::is('vendor/profile*')?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link"
                            href="{{route('vendor.profile.bankView')}}"
                            title="{{translate('messages.bank_info')}}">
                            <i class="tio-shop nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                {{translate('messages.bank_info')}}
                            </span>
                        </a>
                    </li>
                    @endif


                    @if(\App\CentralLogics\Helpers::employee_module_permission_check('wallet'))
                    <!-- StoreWallet -->
                    <li class="navbar-vertical-aside-has-menu {{Request::is('vendor/wallet*')?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('vendor.wallet.index')}}" title="{{translate('messages.my')}} {{translate('messages.wallet')}}"
                        >
                            <i class="tio-table nav-icon"></i>
                            <span
                                class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{translate('messages.my')}} {{translate('messages.wallet')}}</span>
                        </a>
                    </li>
                    @endif
                    <!-- End StoreWallet -->
                    @if(\App\CentralLogics\Helpers::employee_module_permission_check('reviews'))
                    <li class="navbar-vertical-aside-has-menu {{Request::is('vendor-panel/reviews')?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link"
                            href="{{route('vendor.reviews')}}" title="{{translate('messages.reviews')}}"
                        >
                            <i class="tio-star-outlined nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                {{translate('messages.reviews')}}
                            </span>
                        </a>
                    </li>
                    @endif
                    <!-- End Business Settings -->

                    <!-- Employee-->
                    <li class="nav-item">
                        <small class="nav-subtitle" title="{{translate('messages.employee')}} {{translate('messages.section')}}">{{translate('messages.employee')}} {{translate('messages.section')}}</small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>

                    @if(\App\CentralLogics\Helpers::employee_module_permission_check('custom_role'))
                    <li class="navbar-vertical-aside-has-menu {{Request::is('vendor-panel/custom-role*')?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('vendor.custom-role.create')}}"
                        title="{{translate('messages.employee')}} {{translate('messages.Role')}}">
                            <i class="tio-incognito nav-icon"></i>
                            <span
                                class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{translate('messages.employee')}} {{translate('messages.Role')}}</span>
                        </a>
                    </li>
                    @endif

                    @if(\App\CentralLogics\Helpers::employee_module_permission_check('employee'))
                    <li class="navbar-vertical-aside-has-menu {{Request::is('vendor-panel/employee*')?'active':''}}">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                        title="{{translate('messages.employees')}}">
                            <i class="tio-user nav-icon"></i>
                            <span
                                class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{translate('messages.employees')}}</span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                            style="display: {{Request::is('vendor-panel/employee*')?'block':'none'}}">
                            <li class="nav-item {{Request::is('vendor-panel/employee/add-new')?'active':''}}">
                                <a class="nav-link " href="{{route('vendor.employee.add-new')}}" title="{{translate('messages.add')}} {{translate('messages.new')}} {{translate('messages.Employee')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{translate('messages.add')}} {{translate('messages.new')}}</span>
                                </a>
                            </li>
                            <li class="nav-item {{Request::is('vendor-panel/employee/list')?'active':''}}">
                                <a class="nav-link " href="{{route('vendor.employee.list')}}" title="{{translate('messages.Employee')}} {{translate('messages.list')}}">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">{{translate('messages.list')}}</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    @endif
                    <!-- End Employee -->

                    <li class="nav-item" style="padding-top: 100px">

                    </li>
                </ul>
            </div>
            <!-- End Content -->
        </div>
    </aside>
</div>

<div id="sidebarCompact" class="d-none">

</div>


{{--<script>
    $(document).ready(function () {
        $('.navbar-vertical-content').animate({
            scrollTop: $('#scroll-here').offset().top
        }, 'slow');
    });
</script>--}}
