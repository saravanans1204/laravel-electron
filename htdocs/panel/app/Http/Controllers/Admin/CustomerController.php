<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CentralLogics\Helpers;
use App\Models\Newsletter;

class CustomerController extends Controller
{
    public function customer_list(Request $request)
    {
        $key = [];
        if ($request->search) {
            $key = explode(' ', $request['search']);
        }
        $customers = User::when(count($key) > 0, function ($query) use ($key) {
            foreach ($key as $value) {
                $query->orWhere('f_name', 'like', "%{$value}%")
                    ->orWhere('l_name', 'like', "%{$value}%")
                    ->orWhere('email', 'like', "%{$value}%")
                    ->orWhere('phone', 'like', "%{$value}%");
            };
        })
            ->orderBy('order_count', 'desc')->paginate(config('default_pagination'));
        return view('admin-views.customer.list', compact('customers'));
    }

    public function status(User $customer, Request $request)
    {
        $customer->status = $request->status;
        $customer->save();

        try {
            if ($request->status == 0) {
                $customer->tokens->each(function ($token, $key) {
                    $token->delete();
                });
                if (isset($customer->cm_firebase_token)) {
                    $data = [
                        'title' => translate('messages.suspended'),
                        'description' => translate('messages.your_account_has_been_blocked'),
                        'order_id' => '',
                        'image' => '',
                        'type' => 'block'
                    ];
                    Helpers::send_push_notif_to_device($customer->cm_firebase_token, $data);

                    DB::table('user_notifications')->insert([
                        'data' => json_encode($data),
                        'user_id' => $customer->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        } catch (\Exception $e) {
            Toastr::warning(translate('messages.push_notification_faild'));
        }

        Toastr::success(translate('messages.customer') . translate('messages.status_updated'));
        return back();
    }

    public function search(Request $request)
    {
        $key = explode(' ', $request['search']);
        $customers = User::where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('f_name', 'like', "%{$value}%")
                    ->orWhere('l_name', 'like', "%{$value}%")
                    ->orWhere('email', 'like', "%{$value}%")
                    ->orWhere('phone', 'like', "%{$value}%");
            }
        })->orderBy('order_count', 'desc')->limit(50)->get();
        return response()->json([
            'view' => view('admin-views.customer.partials._table', compact('customers'))->render()
        ]);
    }

    public function view($id)
    {
        $customer = User::find($id);
        if (isset($customer)) {
            $orders = Order::latest()->where(['user_id' => $id])->Notpos()->paginate(config('default_pagination'));
            return view('admin-views.customer.customer-view', compact('customer', 'orders'));
        }
        Toastr::error(translate('messages.customer_not_found'));
        return back();
    }

    public function subscribedCustomers()
    {
        $data['subscribedCustomers'] = Newsletter::orderBy('id', 'desc')->get();
        return view('admin-views.customer.subscribed-emails', $data);
    }
    public function subscriberMailSearch(Request $request)
    {
        $key = explode(' ', $request['search']);
        $customers = Newsletter::where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('email', 'like', "%". $value."%");
            }
        })->orderBy('id', 'desc')->get();
        return response()->json([
            'view' => view('admin-views.customer.partials._subscriber-email-table', compact('customers'))->render()
        ]);
    }
}
