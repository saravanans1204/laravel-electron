<?php

namespace App\Http\Controllers\Vendor;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use Brian2694\Toastr\Facades\Toastr;


class CampaignController extends Controller
{
    function list()
    {
        $campaigns=Campaign::with('stores')->latest()->module(Helpers::get_store_data()->module_id)->paginate(config('default_pagination'));
        return view('vendor-views.campaign.list',compact('campaigns'));
    }

    public function remove_store(Campaign $campaign, $store)
    {
        $campaign->stores()->detach($store);
        $campaign->save();
        Toastr::success(translate('messages.store_remove_from_campaign'));
        return back();
    }
    public function addstore(Campaign $campaign, $store)
    {
        $campaign->stores()->attach($store);
        $campaign->save();
        Toastr::success(translate('messages.store_added_to_campaign'));
        return back();
    }

    public function search(Request $request){
        $key = explode(' ', $request['search']);
        $campaigns=Campaign::
        where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('title', 'like', "%{$value}%");
            }
        })
        ->module(Helpers::get_store_data()->module_id)
        ->limit(50)->get();
        return response()->json([
            'view'=>view('vendor-views.campaign.partials._table',compact('campaigns'))->render()
        ]);
    }

}
