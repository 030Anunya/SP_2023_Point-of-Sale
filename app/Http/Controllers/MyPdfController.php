<?php

namespace App\Http\Controllers;

use App\Models\listsale;
use App\Models\MyShop;
use App\Models\Order;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use PDF;

class MyPdfController extends Controller
{
    public function generatePDFmini($id)
    {
        try {
            $products = products::all();
            $listsale = listsale::find($id);
            $order = Order::find($listsale->id);
            $myshop = MyShop::first();

            foreach ($products as $product) {
                $order = Order::where('listsale_id', $listsale->id)
                    ->where('product_id', $product->id)
                    ->first();

                if ($order) {
                    $product_order[] = [
                        'product_name' => $product->product_name,
                        'product_qty' => $order->product_qty,
                        'product_price' => $order->product_price,
                        'product_total_price' => $order->product_total_price
                    ];
                }
            }

            $data = [
                'id' => $id,
                'shop_name' => $myshop ? $myshop->shop_name : "ไม่ระบุ",
                'shop_img' => $myshop ? $myshop->shop_img : "",
                'shop_address' => $myshop ? $myshop->shop_address : "ไม่ระบุ",
                'order_code' => $listsale->order_code,
                'user_sale' => $listsale->users->first_name . ' ' . $listsale->users->last_name,
                'order' => $product_order,
                'total_price' => $listsale->product_total_price,
                'vat' => $listsale->vat,
                'total_price_vat' => $listsale->price_sum_vat,
                'get_money' => $listsale->get_money,
                'change_money' => $listsale->change_money,
                'by_date' => $listsale->created_at
            ];



            return view('report.billMini', compact('data'));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    public function generatePDFfull($id)
    {
        try {
            $products = products::all();
            $listsale = listsale::find($id);
            $order = Order::find($listsale->id);
            $myshop = MyShop::first();

            foreach ($products as $product) {
                $order = Order::where('listsale_id', $listsale->id)
                    ->where('product_id', $product->id)
                    ->first();

                if ($order) {
                    $product_order[] = [
                        'product_name' => $product->product_name,
                        'product_qty' => $order->product_qty,
                        'product_price' => $order->product_price,
                        'product_total_price' => $order->product_total_price
                    ];
                }
            }

            $data = [
                'id' => $id,
                'shop_name' => $myshop ? $myshop->shop_name : "ไม่ระบุ",
                'shop_img' => $myshop ? $myshop->shop_img : "",
                'shop_address' => $myshop ? $myshop->shop_address : "ไม่ระบุ",
                'order_code' => $listsale->order_code,
                'user_sale' => $listsale->users->first_name . ' ' . $listsale->users->last_name,
                'order' => $product_order,
                'total_price' => $listsale->product_total_price,
                'vat' => $listsale->vat,
                'total_price_vat' => $listsale->price_sum_vat,
                'get_money' => $listsale->get_money,
                'change_money' => $listsale->change_money,
                'by_date' => $listsale->created_at
            ];

            return view('report.billFull', compact('data'));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function generatePDFproduct()
    {
        try {
            $data = products::with('category')->orderBy('created_at', 'desc')->get();

            return view('report.allProduct', compact('data'));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
