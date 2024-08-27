<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Mengambil semua data produk
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'product_name' => 'required|max:150',
            'category' => 'required|max:100',
            'price' => 'required|numeric',
        ]);

        // Membuat produk baru
        $product = Product::create($request->all());

        // Mengembalikan data produk yang baru dibuat
        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // Mengembalikan data produk berdasarkan ID
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // Validasi data yang diterima
        $request->validate([
            'product_name' => 'sometimes|required|max:150',
            'category' => 'sometimes|required|max:100',
            'price' => 'sometimes|required|numeric',
        ]);

        // Memperbarui data produk
        $product->update($request->all());

        // Mengembalikan data produk yang telah diperbarui
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // Menghapus produk berdasarkan ID
        $product->delete();

        // Mengembalikan respon berhasil
        return response()->json(null, 204);
    }
}
