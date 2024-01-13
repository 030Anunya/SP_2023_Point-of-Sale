<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\subcategory;
use Illuminate\Http\Request;

class subcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategorys = subcategory::with('category')->get();
        $categories = category::all();
        return view('pages.category.sub_category',compact('subcategorys','categories'));
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
        $subcategory = new subcategory;
        $subcategory->category_id = $request->input('selct_category');
        $subcategory->sub_category_name = $request->input('sub_category_name');
        if ($subcategory->save()) {
            return redirect()->route('subcategory.index')->with('message', 'เพิ่มประเภทสินค้าสำเร็จ');
        } else {
            return redirect()->route('subcategory.index')->with('error', 'เกิดข้อผิดพลาดบางอย่าง');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subcategorys = subcategory::where('category_id',$id)->get();
        return response()->json($subcategorys);
        
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
        $subcategory = subcategory::findOrfail($id);
        $subcategory->sub_category_name = $request->input('sub_category_name_edit');
        $subcategory->category_id = $request->input('selct_category_sub');
        if ($subcategory->save()) {
            return redirect()->route('subcategory.index')->with('message', 'อัพเดตประเภทสินค้าสำเร็จ');
        } else {
            return redirect()->route('subcategory.index')->with('error', 'เกิดข้อผิดพลาดบางอย่าง');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $subcategory = subcategory::findOrFail($id);
            $subcategory->delete();

            return to_route('subcategory.index')->with('message', 'ลบหมวดประเภทสินค้าสำเร็จ');
        } catch (\Exception $e) {
            // . $e->getMessage()
            return to_route('subcategory.index')->with('error', 'ไม่สามารถลบประเภทสินค้านี้ได้');
        }
    }
}
