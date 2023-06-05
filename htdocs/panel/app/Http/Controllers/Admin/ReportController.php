<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\OrderTransaction;
use App\Models\Zone;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Scopes\StoreScope;

class ReportController extends Controller
{
    public function order_index()
    {
        if (session()->has('from_date') == false) {
            session()->put('from_date', date('Y-m-01'));
            session()->put('to_date', date('Y-m-30'));
        }
        return view('admin-views.report.order-index');
    }

    public function day_wise_report(Request $request)
    {
        if (session()->has('from_date') == false) {
            session()->put('from_date', date('Y-m-01'));
            session()->put('to_date', date('Y-m-30'));
        }

        $zone_id = $request->query('zone_id', isset(auth('admin')->user()->zone_id)?auth('admin')->user()->zone_id:'all');
        $zone = is_numeric($zone_id)?Zone::findOrFail($zone_id):null;
        return view('admin-views.report.day-wise-report', compact('zone'));
    }

    public function item_wise_report(Request $request)
    {
        if (session()->has('from_date') == false) {
            session()->put('from_date', now()->firstOfMonth()->format('Y-m-d'));
            session()->put('to_date', now()->lastOfMonth()->format('Y-m-d'));
        }
        $from = session('from_date');
        $to = session('to_date');

        $zone_id = $request->query('zone_id', isset(auth('admin')->user()->zone_id)?auth('admin')->user()->zone_id:'all');
        $store_id = $request->query('store_id', 'all');
        $zone = is_numeric($zone_id)?Zone::findOrFail($zone_id):null;
        $store = is_numeric($store_id)?Store::findOrFail($store_id):null;
        $items = \App\Models\Item::withoutGlobalScope(StoreScope::class)->withCount([
            'orders' => function($query)use($from, $to) {
                $query->whereBetween('created_at', [$from.' 00:00:00', $to.' 23:59:29']);
            },
        ])
        ->when($request->query('module_id', null), function($query)use($request){
            return $query->module($request->query('module_id'));
        })
        ->when(isset($zone), function($query)use($zone){
            return $query->whereIn('store_id', $zone->stores->pluck('id'));
        })
        ->when(isset($store), function($query)use($store){
            return $query->where('store_id', $store->id);
        })
        ->paginate(config('default_pagination'))->withQueryString();

        return view('admin-views.report.item-wise-report', compact('zone', 'store', 'items'));
    }

    public function stock_report(Request $request)
    {
        $zone_id = $request->query('zone_id', isset(auth('admin')->user()->zone_id)?auth('admin')->user()->zone_id:'all');
        $store_id = $request->query('store_id', 'all');
        $zone = is_numeric($zone_id)?Zone::findOrFail($zone_id):null;
        $store = is_numeric($store_id)?Store::findOrFail($store_id):null;
        $stock_modules = array_keys(array_filter(config('module'), function($var){
                if(isset($var['stock']) && $var['stock']) return $var;
            }));
        $key = isset($request['search'])?explode(' ', $request['search']):[];
        
        $items = Item::withoutGlobalScope(StoreScope::class)->whereHas('store.module', function($query)use($stock_modules){
            $query->whereIn('module_type', $stock_modules);
        })
        ->when($request->query('module_id', null), function($query)use($request){
            return $query->module($request->query('module_id'));
        })
        ->when(isset($zone), function($query)use($zone){
            return $query->whereIn('store_id', $zone->stores->pluck('id'));
        })
        ->when(isset($store), function($query)use($store){
            return $query->where('store_id', $store->id);
        })
        ->when(count($key), function($query)use($key){
            return $query->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%");
                }
            });
        })
        ->orderBy('stock')
        ->paginate(config('default_pagination'))->withQueryString();

        return view('admin-views.report.stock-report', compact('zone', 'store', 'items'));
    }

    public function order_transaction()
    {
        $order_transactions = OrderTransaction::latest()->paginate(config('default_pagination'));
        return view('admin-views.report.order-transactions', compact('order_transactions'));
    }


    public function set_date(Request $request)
    {
        session()->put('from_date', date('Y-m-d', strtotime($request['from'])));
        session()->put('to_date', date('Y-m-d', strtotime($request['to'])));
        return back();
    }

    public function item_search(Request $request){
        $key = explode(' ', $request['search']);

        $from = session('from_date');
        $to = session('to_date');

        $zone_id = $request->query('zone_id', isset(auth('admin')->user()->zone_id)?auth('admin')->user()->zone_id:'all');
        $store_id = $request->query('store_id', 'all');
        $zone = is_numeric($zone_id)?Zone::findOrFail($zone_id):null;
        $store = is_numeric($store_id)?Store::findOrFail($store_id):null;
        $items = \App\Models\Item::withoutGlobalScope(StoreScope::class)->withCount([
            'orders as order_count' => function($query)use($from, $to) {
                $query->whereBetween('created_at', [$from, $to]);
            },
        ])
        ->when(isset($zone), function($query)use($zone){
            return $query->whereIn('store_id', $zone->stores->pluck('id'));
        })
        ->when(isset($store), function($query)use($store){
            return $query->where('store_id', $store->id);
        })
        ->where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('name', 'like', "%{$value}%");
            }
        })
        ->limit(25)->get();

        return response()->json(['count'=>count($items),
            'view'=>view('admin-views.report.partials._item_table',compact('items'))->render()
        ]);
    }
}
