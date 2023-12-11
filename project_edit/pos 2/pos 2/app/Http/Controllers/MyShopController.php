<?php

namespace App\Http\Controllers;

use App\Models\MyShop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MyShopController extends Controller
{
    public function index()
    {
        $shop = MyShop::first();
        return view('pages.myshop.seting', compact('shop'));
    }

    public function update(Request $request)
    {

        if ($request->has('id') && !empty($request->input('id'))) {
            $shop = MyShop::find($request->input('id'));
        } else {
            $shop = new MyShop;
        }

        $shop->phone = $request->input('phone');
        $shop->shop_name = $request->input('shop_name');
        $shop->shop_address = $request->input('shop_address');
        $shop->line_token = $request->input('line_token');

        if ($request->hasFile('image')) {
            Storage::delete('public/uploads/' . $shop->shop_img);
            $imageFile = $request->file('image');
            $fileName = time() . '.' . $imageFile->extension();
            $imageFile->storeAs('public/uploads', $fileName);
            $shop->shop_img = $fileName;
        }

        $shop->save();

        return redirect(url('/myshop'))->with('message', 'อัพเดตข้อมูลร้านสำเร็จ');
    }
}
