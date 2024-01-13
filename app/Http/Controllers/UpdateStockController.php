<?php

namespace App\Http\Controllers;

use App\Models\products;
use Illuminate\Http\Request;

class UpdateStockController extends Controller
{
    public function updateStock(Request $request)
    {
        $status = 0;
        $message = '';
        $qty = $request->input('qty');
        $product_id = $request->input('id_product');
        $product = products::findOrfail($product_id);

        if ($request->qty[0] !== null) {
            $status = 1;
        } else if ($request->qty[1] !== null) {
            $status = 2;
        } else {
            $status = 3;
        }


        if ($status == 1) {
            $product->stock = $qty[0];
            $message = 'อัพเดตสต็อคสำเร็จ';
        } elseif ($status == 2) {
            $product->stock += $qty[1];
            $message = 'เพิ่มสต็อคสำเร็จ';
        } elseif ($status == 3) {
            $product->stock -= $qty[2];
            $message = 'ลดสต็อคสำเร็จ';
        }

        $product->save();
        return redirect()->back()->with('message', $message);
    }


}
