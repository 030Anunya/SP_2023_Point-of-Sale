<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\products;
use App\Models\subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class inventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = products::leftJoin('orders', 'products.id', '=', 'orders.product_id')
            ->select('products.*', DB::raw('SUM(IFNULL(orders.product_qty, 0)) as total_qty'))
            ->groupBy('products.id')
            ->with('category', 'subcategory')
            ->get();

        $categorys = Category::all();
        $subcategorys = Subcategory::all();

        if (request()->wantsJson()) {
            return response()->json(['products' => $products]);
        } else {
            return view('pages.stock.inventory', compact('products', 'subcategorys', 'categorys'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = products::join('orders', 'products.id', '=', 'orders.product_id')
            ->select('products.*', DB::raw('SUM(orders.product_qty) as total_qty'))
            ->where('products.id', $id)
            ->groupBy('products.id')
            ->with('category', 'subcategory')
            ->first();
    
        if (!$product) {
            $product = products::find($id);
        }
    
        if (request()->wantsJson()) {
            return response()->json(['product' => $product]);
        } else {
            return view('inventory.index', compact('product'));
        }
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
