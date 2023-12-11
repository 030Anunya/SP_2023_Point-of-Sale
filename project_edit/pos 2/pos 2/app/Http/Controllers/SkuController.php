<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\Sku;
use Illuminate\Http\Request;

class SkuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allSku = Sku::all();
        if (request()->wantsJson()) {
            return response()->json($allSku);
        } else {
            return view('pages.feature.sku', compact('allSku'));
        }
  
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
        $sku = new Sku;
        $sku->sku_name = $request->sku;
        $sku->save();
        return back()->with('message','เพิ่มคุณสมบัติสำเร็จ');
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
        $allSku = Sku::all();
        $skuEdit = Sku::find($id);
        return view('pages.feature.sku',compact('skuEdit','allSku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sku = Sku::find($id);
        // dd($request->all());
        $sku->sku_name = $request->get('sku');
        $sku->save();
        return to_route('feature.index')->with('message','อัพเดตคุณสมบัติสำเร็จ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sku = Sku::find($id);
        $sku->delete();
        return to_route('feature.index')->with('message','ลบคุณสมบัติสำเร็จ');
    }
}
