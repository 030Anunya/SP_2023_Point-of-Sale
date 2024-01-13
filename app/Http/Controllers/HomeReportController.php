<?php

namespace App\Http\Controllers;

use App\Models\listsale;
use App\Models\products;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeReportController extends Controller
{
    public function index()
    {
        $all_products = products::all();
        $product_count = $all_products->count();

        $all_listsale = listsale::all();
        $listsale_count = $all_listsale->count();

        $currentMonth = Carbon::now()->format('m');
        $all_listsale = listsale::whereMonth('created_at', $currentMonth)->get();
        $listsale_count_month = $all_listsale->count();

        $currentDay = Carbon::now()->day;
        $all_listsale = listsale::whereDay('created_at', $currentDay)->get();
        $listsale_count_day = $all_listsale->count();

        $custromer = User::all();
        $coustomer_count = $custromer->count();

        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $totalProductPriceMonth = listsale::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->sum('price_sum_vat');

        $currentDate = Carbon::now()->format('Y-m-d');
        $totalProductPriceDay = listsale::whereDate('created_at', $currentDate)->sum('price_sum_vat');

        $totalProductPriceAll = listsale::sum('price_sum_vat');

        $currentDate = Carbon::now()->toDateString(); // Get the current date in 'Y-m-d' format

        $listSales = listsale::with('users')
            ->whereDate('created_at', '=', $currentDate)
            ->get();


        return view(
            'pages.home',
            compact(
                'product_count',
                'listsale_count',
                'listsale_count_month',
                'listsale_count_day',
                'coustomer_count',
                'totalProductPriceMonth',
                'totalProductPriceDay',
                'totalProductPriceAll',
                'listSales',

            )
        );
    }
}
