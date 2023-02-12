<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Carbon;

class OrderController extends BaseController
{
    public function index()
    {
        $newOrders = Order::where('order_status', 'placed')
            ->where('store_id', Auth::user()->userstore->id)
            ->get();

        $deliveredOrders = Order::where('order_status', 'delivered')
            ->where('store_id', Auth::user()->userstore->id)
            ->get();

        // Loop through each order to fetch its corresponding items
        foreach ($newOrders as $newOrder) {
            $newOrder->items = $newOrder->orderItem()->get();
        }

        foreach ($deliveredOrders as $deliveredOrder) {
            $deliveredOrder->items = $deliveredOrder->orderItem()->get();
        }

        $pageTitle = 'Orders';
        $userStoreCheck = $this->checkUserStore();
        $newOrdersCount = $userStoreCheck['newOrdersCount'];

        return view('orders', compact(
            'pageTitle',
            'userStoreCheck',
            'newOrders',
            'newOrdersCount',
            'deliveredOrders'
        ));
    }

    public function acceptOrder(Request $request, Order $order)
    {
        $order->update(['order_status' => 'processing']);
        return redirect()->route('orders.index'); 
    }

    public function generateDemoOrders()
    {
        $store = optional(Auth::user())->userstore;

        if (!$store) {
            return back()->with('error', 'Create your store before generating demo orders.');
        }

        $products = Product::where('store_id', $store->id)->take(3)->get();

        if ($products->isEmpty()) {
            return back()->with('error', 'Add at least one product before generating demo orders.');
        }

        $demoOrders = [
            ['status' => 'placed', 'address' => '12 Admiralty Way, Lekki, Lagos', 'amount' => 8500],
            ['status' => 'placed', 'address' => '5 Isaac John Street, Ikeja, Lagos', 'amount' => 11200],
            ['status' => 'delivered', 'address' => '23 Herbert Macaulay Way, Yaba, Lagos', 'amount' => 6400],
        ];

        foreach ($demoOrders as $index => $demoOrder) {
            $order = Order::create([
                'store_id' => $store->id,
                'order_status' => $demoOrder['status'],
                'order_date' => Carbon::now()->subHours(6 - $index),
                'total_amount' => $demoOrder['amount'],
                'delivery_address' => $demoOrder['address'],
            ]);

            foreach ($products as $product) {
                $order->orderItem()->create([
                    'product' => $product->name,
                    'quantity' => rand(1, 3),
                ]);
            }
        }

        return back()->with('success', 'Demo orders generated successfully.');
    }
}
