<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Feedback;
use App\Models\Order;
use App\Models\Product;

// fixme - implement mustverifyemail
class AppController extends BaseController
{
    // display dashboard
    public function index()
    {
        $userStoreCheck = $this->checkUserStore();
        $store = optional(Auth::user())->userstore;
        $productCount = $store ? Product::where('store_id', $store->id)->count() : 0;
        $newOrdersCount = $store
            ? Order::where('store_id', $store->id)->where('order_status', 'placed')->count()
            : 0;
        $deliveredOrdersCount = $store
            ? Order::where('store_id', $store->id)->where('order_status', 'delivered')->count()
            : 0;
        $totalRevenue = $store
            ? (float) Order::where('store_id', $store->id)->where('order_status', 'delivered')->sum('total_amount')
            : 0;
        $averageRating = $store
            ? (float) Feedback::where('store_id', $store->id)->avg('rating')
            : 0;

        return view('dashboard', array_merge($userStoreCheck, [
            'productCount' => $productCount,
            'newOrdersCount' => $newOrdersCount,
            'deliveredOrdersCount' => $deliveredOrdersCount,
            'totalRevenue' => $totalRevenue,
            'averageRating' => $averageRating,
        ]));

    }
}
