<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InsightsController extends BaseController
{
    public function earnings()
    {
        $store = $this->currentStore();
        $pageTitle = 'Earnings';
        $userStoreCheck = $this->checkUserStore();
        $newOrdersCount = $userStoreCheck['newOrdersCount'];

        $totalRevenue = 0;
        $monthlyRevenue = 0;
        $averageOrderValue = 0;
        $recentDeliveredOrders = collect();

        if ($store) {
            $deliveredOrders = Order::where('store_id', $store->id)
                ->where('order_status', 'delivered');

            $totalRevenue = (float) $deliveredOrders->sum('total_amount');
            $monthlyRevenue = (float) Order::where('store_id', $store->id)
                ->where('order_status', 'delivered')
                ->whereDate('order_date', '>=', Carbon::now()->startOfMonth())
                ->sum('total_amount');
            $averageOrderValue = (float) Order::where('store_id', $store->id)
                ->where('order_status', 'delivered')
                ->avg('total_amount');
            $recentDeliveredOrders = Order::where('store_id', $store->id)
                ->where('order_status', 'delivered')
                ->orderByDesc('order_date')
                ->limit(10)
                ->get();
        }

        return view('earnings', compact(
            'pageTitle',
            'userStoreCheck',
            'newOrdersCount',
            'totalRevenue',
            'monthlyRevenue',
            'averageOrderValue',
            'recentDeliveredOrders'
        ));
    }

    public function feedback()
    {
        $store = $this->currentStore();
        $pageTitle = 'Feedback';
        $userStoreCheck = $this->checkUserStore();
        $newOrdersCount = $userStoreCheck['newOrdersCount'];

        $feedback = collect();
        $averageRating = 0;
        $feedbackCount = 0;

        if ($store) {
            $feedback = Feedback::where('store_id', $store->id)
                ->latest()
                ->get();
            $averageRating = (float) Feedback::where('store_id', $store->id)->avg('rating');
            $feedbackCount = Feedback::where('store_id', $store->id)->count();
        }

        return view('feedback', compact(
            'pageTitle',
            'userStoreCheck',
            'newOrdersCount',
            'feedback',
            'averageRating',
            'feedbackCount'
        ));
    }

    public function generateDemoFeedback()
    {
        $store = $this->currentStore();

        if (!$store) {
            return back()->with('error', 'Create your store before generating demo feedback.');
        }

        $deliveredOrders = Order::where('store_id', $store->id)
            ->where('order_status', 'delivered')
            ->get();

        if ($deliveredOrders->isEmpty()) {
            return back()->with('error', 'Generate or complete a delivered order before creating demo feedback.');
        }

        $templates = [
            ['customer_name' => 'Ada', 'rating' => 5, 'comment' => 'Fast delivery and the food arrived fresh.'],
            ['customer_name' => 'Kemi', 'rating' => 4, 'comment' => 'Great portion size and reliable packaging.'],
            ['customer_name' => 'Tunde', 'rating' => 5, 'comment' => 'Would order again. The taste was excellent.'],
        ];

        foreach ($deliveredOrders as $index => $order) {
            if (Feedback::where('order_id', $order->id)->exists()) {
                continue;
            }

            $template = $templates[$index % count($templates)];

            Feedback::create([
                'order_id' => $order->id,
                'store_id' => $store->id,
                'customer_name' => $template['customer_name'],
                'rating' => $template['rating'],
                'comment' => $template['comment'],
            ]);
        }

        return back()->with('success', 'Demo feedback generated successfully.');
    }

    public function reports()
    {
        $store = $this->currentStore();
        $pageTitle = 'Reports';
        $userStoreCheck = $this->checkUserStore();
        $newOrdersCount = $userStoreCheck['newOrdersCount'];

        $statusCounts = collect();
        $topProducts = collect();
        $dailyRevenue = collect();

        if ($store) {
            $statusCounts = Order::select('order_status', DB::raw('count(*) as total'))
                ->where('store_id', $store->id)
                ->groupBy('order_status')
                ->get();

            $topProducts = DB::connection('foody_customers')
                ->table('order_items')
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->select('order_items.product', DB::raw('sum(order_items.quantity) as total_quantity'))
                ->where('orders.store_id', $store->id)
                ->groupBy('order_items.product')
                ->orderByDesc('total_quantity')
                ->limit(5)
                ->get();

            $dailyRevenue = Order::select(
                    DB::raw("date(order_date) as order_day"),
                    DB::raw('sum(total_amount) as total_revenue')
                )
                ->where('store_id', $store->id)
                ->where('order_status', 'delivered')
                ->whereDate('order_date', '>=', Carbon::now()->subDays(6)->startOfDay())
                ->groupBy(DB::raw("date(order_date)"))
                ->orderBy('order_day')
                ->get();
        }

        return view('reports', compact(
            'pageTitle',
            'userStoreCheck',
            'newOrdersCount',
            'statusCounts',
            'topProducts',
            'dailyRevenue'
        ));
    }

    private function currentStore()
    {
        return optional(Auth::user())->userstore;
    }
}
