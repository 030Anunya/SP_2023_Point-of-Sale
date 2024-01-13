<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\listsale;
use App\Models\MyShop;
use App\Models\Order;
use App\Models\products;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class listsaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.listsale');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $salelist = new listsale;
        $myshop = MyShop::first();
        $salelist->user_id = Auth::user()->id;
        $salelist->count_cart = 1;
        $salelist->get_money = $request->input('getMoney');
        $salelist->change_money = $request->input('changeMoney');
        $salelist->product_total_price = $request->input('totalPrice');
        $salelist->price_sum_vat = $request->input('totalPriceVat');
        $salelist->vat = $request->input('vat');
        $salelist->save();
        foreach ($request->input('cart') as $product) {
            $order = new Order;
            $products = products::find($product['product_id']);

            if (!$product) {
                continue;
            }

            $products->stock -= $product['quantity'];
            $products->save();

            $order->product_cost = $product['product_cost'];
            $order->product_id = $product['product_id'];
            $order->feature = $product['feature'];
            $order->product_qty = $product['quantity'];
            $order->product_price = $product['product_price'];
            $order->product_total_price = $request->input('totalPrice') + $request->input('vat');
            $order->vat = $request->input('vat');
            $salelist->orders()->save($order);
        }

        $date = Carbon::now();
        $formattedDate = $date->format('m/d/Y H:i');
        $message = '';
        $message = "มีการขายสินค้า\n";
        $message .= "วันที่ขาย " . $formattedDate . " น.\n";
        $message .= "รหัสการขาย : " . $salelist->order_code . "\n";
        foreach ($request->input('cart') as $product) {
            $message .= "สินค้า : " . $product['product_name'] . " x" . $product['quantity'] . "\n";
        }
        $message .= "ราคารวมสินค้า : " . number_format($request->input('totalPrice'),2) . "\n";
        $message .= "ภาษีมูลค่าเพิ่ม 7 % : " . number_format($request->input('vat'),2) . "\n";
        $message .= "ราคาหลังเสียภาษี : " . number_format($request->input('totalPriceVat'),2) . "\n";
        $message .= "รับเงิน : " . number_format($request->input('getMoney'),2) . "\n";
        $message .= "ทอนเงิน : " . number_format($request->input('changeMoney'), 2) . "\n";
        if(!empty($myshop)){
            $token = !empty($myshop) ? $myshop->line_token : "";

            $client = new Client();
            $sendLineNotify = $client->post('https://notify-api.line.me/api/notify', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
                'form_params' => [
                    'message' => $message,
                ],
            ]);
        }
     

        return response()->json(['Print_id' => $salelist->id]);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
