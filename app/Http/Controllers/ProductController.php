<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ProductT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $product = ProductT::select(['product_id', 'nama_product', 'harga_jual'])->get();
        // dd($product);
        return view('product.index', compact('product'));
    }

    public function insert(Request $request) {
        // dd($request->all());

         // Validasi input
         $validator = Validator::make($request->all(), [
            'nama_product' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'jumlah_stok' => 'required',
        ], [
            'nama_product.required' => 'Nama product wajib diisi.',
            'harga_beli.required' => 'Harga beli wajib diisi.',
            'harga_jual.required' => 'Harga jual wajib diisi.',
            'jumlah_stok.required' => 'Jumlah stok wajib diisi.',
        ], [
            'nama_product' => 'Nama Product',
            'harga_beli' => 'Harga Beli',
            'harga_jual' => 'Harga Jual',
            'jumlah_stok' => 'Jumlah Stok',
        ]);

        // Jika validasi gagal, kirim pesan error
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        
        $regis = ProductT::find($request->product_id ?? 0) ?? new ProductT;
        $regis->nama_product = $request->nama_product ?? null;
        $regis->harga_beli = $request->harga_beli ?? null;
        $regis->harga_jual = $request->harga_jual ?? null;
        $regis->jumlah_stok = $request->jumlah_stok ?? null;
        $regis->created_at = Carbon::now();
        $regis->creator_id = auth()->user()->id;
        $regis->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil disimpan'
        ]);
    }


    public function load_table (Request $request) {
        $data = ProductT::select('*')
                // ->where('jumlah_stok', '>', 0)
                ->orderBy('created_at', 'desc')
                ->get();
        
        foreach ($data as $key => $value) {
            $value->tanggalentri = Carbon::parse($value->created_at)->isoFormat('dddd, D MMMM Y HH:mm');
        }
        
        return response()->json($data);
    }

    public function checkout(Request $request) {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_product' => 'required',
            'jumlah_checkout' => 'required',
        ], [
            'nama_product.required' => 'Nama product wajib diisi.',
            'jumlah_checkout.required' => 'Jumlah wajib diisi.',
        ], [
            'nama_product' => 'Nama Product',
            'jumlah_checkout' => 'Jumlah',
        ]);
    
        // Jika validasi gagal, kirim pesan error
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
    
        // Mengecek stok produk
        $product = ProductT::where('product_id', $request->nama_product)->first();
        if (!$product) {
            return response()->json([
                'errors' => 'Produk tidak ditemukan'
            ], 404);
        }
    
        $checkstok = $product->jumlah_stok;
    
        // Mengecek jika stok tidak mencukupi
        if ($checkstok < $request->jumlah_checkout) {
            return response()->json([
                'error' => 'Stok Tidak Cukup, Stok Tersedia: ' . $checkstok
            ], 422);
        }
    
        // Mengurangi stok dan memperbarui data produk
        $product->jumlah_stok = $checkstok - $request->jumlah_checkout;
        $product->updated_at = Carbon::now();
        $product->updator_id = auth()->user()->id;
        $product->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil disimpan'
        ]);
    }

    public function edit (Request $request) {
        $edit = ProductT::where('product_id', $request->product_id)->first();

        if (!$edit) {
            return response()->json([
                'errors' => 'Produk tidak ditemukan'
            ], 404);
        } 

        return response()->json($edit);
    }

    public function delete (Request $request) {
        $edit = ProductT::where('product_id', $request->product_id)->exists();

        if (!$edit) {
            return response()->json([
                'errors' => 'Produk tidak ditemukan'
            ], 404);
        } else {
            ProductT::where('product_id', $request->product_id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil dihapus'
            ]);
        }

    }
    
}
