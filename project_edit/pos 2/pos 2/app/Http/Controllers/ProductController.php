<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Feature;
use App\Models\products;
use App\Models\subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use BaconQrCode\Renderer\Image\Png;
use Illuminate\Support\Facades\App;


use Maatwebsite\Excel\Facades\Excel;
use function PHPUnit\Framework\isEmpty;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (request()->wantsJson()) {
            $products = products::with('category', 'subcategory', 'features')
                ->where('status', 1)
                ->where(function ($query) {
                    $query->whereHas('features', function ($subquery) {
                        $subquery->where('stock', '>', 0);
                    })
                        ->orWhere('stock', '>', 1);
                })
                ->orderBy('created_at', 'desc')
                ->get();
            $categorys = category::all();
            $subcategorys = subcategory::all();
            return response()->json(['products' => $products]);
        } else {
            $products = products::with('category', 'subcategory', 'features')
                ->orderBy('created_at', 'desc')
                ->get();
            $categorys = category::all();
            $subcategorys = subcategory::all();
            return view('pages.product.product', compact('products', 'subcategorys', 'categorys'));
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
        // return response()->json($request->all());
        $validatedData = $request->validate([
            'product_name' => 'required|string',
            // 'product_price' => 'required|numeric',
            // 'category' => 'required|string',
            // 'sub_category' => 'required|string',
            // 'code' => 'required',
            // 'stock' => 'required|numeric',
            // 'product_cost' => 'required|numeric',
        ], [
            'product_name.required' => 'กรุณาระบุ',
            // 'product_price.required' => 'กรุณาระบุ',
            // 'product_price.numeric' => 'กรุณากรอกเป็นตัวเลข',
            // 'category.required' => 'กรุณาระบุ',
            // 'sub_category.required' => 'กรุณาระบุ',
            // 'code.required' => 'กรุณาระบุ',
            // 'stock.required' => 'กรุณาระบุ',
            // 'stock.numeric' => 'กรุณากรอกเป็นตัวเลข',
            // 'product_cost.required' => 'กรุณาระบุ',
            // 'product_cost.numeric' => 'กรุณากรอกเป็นตัวเลข',
        ]);

        if ($request->has('id_product') && !empty($request->input('id_product'))) {
            $product = products::find($request->input('id_product'));
            $product->product_name = $validatedData['product_name'];
            $product->product_price = $request->input('product_price');
            $product->category_id = $request->input('category');
            $product->sub_category_id = $request->input('sub_category');
            $product->Expiry_Date = $request->input('Expiry_Date');
            $product->code = $validatedData['code'];
            $product->stock = $request->input('stock');
            $product->weight = $request->input('weight');
            $product->description = $request->input('descripion');
            $product->product_cost = $request->input('product_cost');
            $product->sku_name1 = $request->input('sku_name1');
            $product->sku_name2 = $request->input('sku_name2');


            if ($request->has('image') && !empty($request->file('image'))) {
                $imageFile = $request->file('image');
                $fileName = time() . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->storeAs('public/uploads', $fileName);
                $product->product_img = $fileName;
            }
            $product->save();

            $data = json_decode($request->combinations, true); // Decoding the JSON string into an array
            $deleteFeature = Feature::where('product_id', $request->input('id_product'));
            $deleteFeature->delete();
            if (is_array($data)) {

                foreach ($data as $item) {
                    $feature = new Feature;
                    $feature->feature1 =  $item['feature1'];
                    if (isset($item['feature2'])) {
                        $feature->feature2 = $item['feature2'];
                    }
                    $feature->sku =  $item['sku'];
                    $feature->product_price =  $item['price'];
                    $feature->stock =  $item['count'];
                    $feature->product_id = $product->id;
                    $feature->save();
                }
            }
            return response()->json([
                'type' => 'success',
                'data' => "อัพเดตข้อมูลสำเร็จ"
            ]);
        } else {


            $product = new products;
            if ($request->has('image') && !empty($request->file('image'))) {
                $imageFile = $request->file('image');
                $fileName = time() . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->storeAs('public/uploads', $fileName);
                $product->product_img = $fileName;
            }
            $product->product_name = $validatedData['product_name'];
            $product->product_price = $request->input('product_price');
            $product->category_id = $request->input('category');
            $product->sub_category_id = $request->input('sub_category');
            $product->Expiry_Date = $request->input('Expiry_Date');
            $product->code = $validatedData['code'];
            $product->stock = $request->input('stock');
            $product->weight = $request->input('weight');
            $product->description = $request->input('description');
            $product->product_cost = $request->input('product_cost');
            $product->sku_name1 = $request->input('sku_name1');
            $product->sku_name2 = $request->input('sku_name2');

            $product->save();

            // return response()->json($request->combinations);
            $data = json_decode($request->combinations, true); // Decoding the JSON string into an array

            if (is_array($data)) {

                foreach ($data as $item) {
                    $feature = new Feature;
                    $feature->feature1 =  $item['feature1'];
                    $feature->feature2 = $item['feature2'];
                    $feature->sku =  $item['sku'];
                    $feature->product_price =  $item['price'];
                    $feature->stock =  $item['count'];
                    $feature->product_id = $product->id;
                    $feature->save();
                }

                return response()->json([
                    'type' => 'success',
                    'data' => "เพิ่มข้อมูลสำเร็จ"
                ]);
            } else {
                // Handle JSON decoding error
                echo "Error decoding JSON string";
            }
        }


        // return redirect()->route('products.index')->with('message', 'Product added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $products = products::with('category', 'subcategory', 'features')->find($id);
        return response()->json($products);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return response()->json($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = products::findOrFail($id);
            if ($product->delete()) {
                Storage::delete('public/uploads/' . $product->product_img);
            }

            return redirect()->back()->with('message', 'ลบสินค้าสำเร็จ');
        } catch (\Exception $e) {
            // . $e->getMessage()
            return redirect()->back()->with('error', 'ไม่สามารถลบสินค้านี้ได้');
        }
    }

    public function searchProduct(Request $request)
    {
        $productCode = $request->input('inputSearchProduct');

        $product = products::where('code', $productCode)->first();

        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['error' => 'ไม่มีรหัสสินค้านี้ในระบบ'], 404);
        }
    }

    public function generateQRCode(Request $request, $id)
    {
        $product = products::find($id);
        $count_row = $request->input('count');
        $pdf = App::make('dompdf.wrapper');
        $html = view('pages.barcode', compact('product', 'count_row'))->render();
        $pdf->loadHTML($html);
        return $pdf->stream();
        // return view('pages.barcode', compact('product'));
    }

    public function importProduct(Request $request)
    {
        $file = $request->file('file');

        $data = Excel::toCollection(null, $file)->first();

        if ($data->count() > 0) {


            $firstRow = true;
            foreach ($data as $row) {
                if ($firstRow) {
                    $firstRow = false;
                    continue;
                }
                if (isset($row[0]) && isset($row[2]) && isset($row[1]) && isset($row[3]) && isset($row[4])) {
                    $product = new products();

                    $product->product_name = $row[0];
                    $product->product_price = (float) $row[2];
                    $product->product_cost = (float) $row[1];
                    $product->code = $row[3];
                    $product->stock = (int) $row[4];

                    $product->save();
                }
            }
        }

        return redirect()->back()->with('message', 'นำสินค้าเข้าสำเร็จ');
    }

    public function togglestatus($id)
    {
        $product = products::find($id);
        if ($product->status != 1) {
            $product->status = 1;
        } else {
            $product->status = 0;
        }
        $product->save();
        return redirect()->back()->with('message', 'อัพเดตสถานะเข้าสำเร็จ');
    }
}
