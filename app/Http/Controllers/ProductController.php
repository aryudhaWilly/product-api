<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Mendapatkan parameter halaman dan batas per halaman dari query string
        $perPage = $request->input('per_page', 10); // Default 15 item per halaman
        $page = $request->input('page', 1); // Default halaman pertama

        // Mengambil data produk dengan paginasi
        $products = Product::select('id', 'product_name', 'category', 'price', 'discount') // Pilih kolom yang diperlukan
            ->orderBy('created_at', 'desc') // Urutkan data, bisa disesuaikan
            ->paginate($perPage, ['*'], 'page', $page);

        // Mengembalikan data produk dalam format JSON
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Validasi data yang diterima
            $request->validate([
                'product_name' => 'required|max:150|min:2|unique:products,product_name',
                'category' => 'required|max:100',
                'price' => 'required|numeric',
                'discount' => 'nullable|numeric|min:0|max:100',
            ]);

            // Membuat produk baru
            $product = Product::create($request->all());

            // Mengembalikan data produk yang baru dibuat
            return response()->json($product, 201);
        } catch (ValidationException $e) {
            // Mengembalikan pesan kesalahan validasi dalam bentuk JSON
            return response()->json([
                'errors' => $e->errors()
            ], 422); // Status kode 422 Unprocessable Entity
        } catch (\Exception $e) {
            // Mengembalikan pesan kesalahan umum dalam bentuk JSON
            return response()->json([
                'error' => 'Terjadi kesalahan saat menyimpan produk. Silakan coba lagi.'
            ], 500); // Status kode 500 Internal Server Error
        }
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
        try {
            // Validasi data yang diterima
            $request->validate([
                'product_name' => 'required|max:150|min:0|unique:products,product_name',
                'category' => 'required|max:100',
                'price' => 'required|numeric|min:0',
                'discount' => 'nullable|numeric|min:0|max:100',
            ]);

            // Membuat produk baru
            $product = Product::create($request->all());

            // Mengembalikan data produk yang baru dibuat
            return response()->json($product, 201);
        } catch (ValidationException $e) {
            // Mengembalikan pesan kesalahan validasi dalam bentuk JSON
            return response()->json([
                'errors' => $e->errors()
            ], 422); // Status kode 422 Unprocessable Entity
        } catch (\Exception $e) {
            // Mengembalikan pesan kesalahan umum dalam bentuk JSON
            return response()->json([
                'error' => 'Terjadi kesalahan saat menyimpan produk. Silakan coba lagi.'
            ], 500); // Status kode 500 Internal Server Error
        }
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
