<?php

namespace App\Http\Controllers;

use App\Models\listsale;
use App\Models\MyShop;
use App\Models\Order;
use App\Models\products;
use App\Models\User;
use Illuminate\Http\Request;

class HistorySaleController extends Controller
{
    public function showHistorySale()
    {
        $listSales = listsale::with('users')->get();

        return view('pages.listsale.historySale', compact('listSales'));
    }

    public function detailHistory($id)
    {
        $orders = Order::where('listsale_id', $id)->get();
        $listsale = listsale::find($id);
        $user = User::find($listsale->user_id);

    
        if ($orders->isEmpty()) {
            return abort(404);
        }
        $associatedProducts = [];

        foreach ($orders as $order) {
            $associatedProducts[] = [
                'id'=>$id,
                'features'=>$order->feature,
                'product_name' => $order->product->product_name,
                'product_qty' => $order->product_qty,
                'product_price' => $order->product_price,
                'vat' => $order->vat,
                'product_total_price' => $order->product_total_price,
                'order_code' => $listsale->order_code,
                'sale_date' => $listsale->created_at,
                'customer_name' => $user->first_name . ' ' . $user->last_name,
                'phone' => $user->phone
            ];
        }


        return view('pages.listsale.detailHistorySale', compact('associatedProducts'));
    }
    public function showHistoryMonth(Request $request)
    {
        $yearShow = date('Y') + 543;
        if ($request->has('year')) {
            $selectedYear = $request->input('year');
            $yearShow = $selectedYear + 543;

            $monthlyData = listsale::selectRaw('MONTH(created_at) as month, SUM(product_total_price) as total_price')
                ->whereYear('created_at', $selectedYear)
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        } else {
            $monthlyData = listsale::selectRaw('MONTH(created_at) as month, SUM(product_total_price) as total_price')
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        }

        $thaiMonths = [
            'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
            'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
        ];
        $labels = [];
        $data = [];

        foreach ($monthlyData as $record) {
            $formattedDate = $thaiMonths[$record->month - 1]; // Add 543 to convert the year to Thai Buddhist era
            $labels[] = $formattedDate;
            $data[] = $record->total_price;
        }

        return view('pages.listsale.historySaleMonth', compact('labels', 'data', 'yearShow'));
    }

    public function showHistoryProduct()
    {
        // Retrieve all products
        $products = products::all();

        // Load the related orders for each product and pluck the prices
        $productPrices = $products->map(function ($product) {
            $sumPrice = $product->orders->sum(function ($order) {
                return $order->product_price * $order->product_qty;
            });
            $sumCost = $product->orders->sum(function ($order) {
                return $order->product_cost * $order->product_qty;
            });
            $sumQty = $product->orders->sum('product_qty');
            return [
                'product' => $product,
                'sale_qty' => $sumQty,
                'sum_price' => $sumPrice,
                'product_cost' => $sumCost,
            ];
        });


        return view('pages.listsale.historyProduct', compact('productPrices'));
    }

    public function showHistorySaleYear()
    {
        $yearlyData = listsale::selectRaw('YEAR(created_at) as year, SUM(product_total_price) as total_price')
            ->groupBy('year')
            ->orderBy('year')
            ->get();
        $labels = [];
        $data = [];

        foreach ($yearlyData as $record) {
            $labels[] = $record->year;
            $data[] = $record->total_price;
        }

        return view('pages.listsale.historySaleYear', compact('labels', 'data'));
    }

    public function costCustomer()
    {
        return view('pages.customer.costUser');
    }
}
