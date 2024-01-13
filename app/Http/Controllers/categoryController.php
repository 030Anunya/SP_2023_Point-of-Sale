<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\products;
use Illuminate\Http\Request;

class categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorys = category::all();

        if (request()->wantsJson()) {
            return response()->json(['category' => $categorys]);
        } else {
            return view('pages.category.category', compact('categorys'));
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
        $validatedData = $request->validate([
            'category_name' => 'required|string',
        ]);
        $category = new category;
        $category->category_name = $validatedData['category_name'];
        if ($category->save()) {
            return redirect()->route('categorys.index')->with('message', 'เพิ่มหมวดหมู่สินค้าสำเร็จ');
        } else {
            return redirect()->route('categorys.index')->with('error', 'เกิดข้อผิดพลาดบางอย่าง');
        }
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
        // dd($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = category::findOrfail($id);
        $category->category_name = $request->input('category_name_edit');
        if ($category->save()) {
            return redirect()->route('categorys.index')->with('message', 'เพิ่มหมวดหมู่สินค้าสำเร็จ');
        } else {
            return redirect()->route('categorys.index')->with('error', 'เกิดข้อผิดพลาดบางอย่าง');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = category::findOrFail($id);
            $category->delete();

            return to_route('categorys.index')->with('message', 'ลบหมวดหมู่สินค้าสำเร็จ');
        } catch (\Exception $e) {
            // . $e->getMessage()
            return to_route('categorys.index')->with('error', 'ไม่สามารถลบหมู่สินค้านี้ได้');
        }
    }
}
