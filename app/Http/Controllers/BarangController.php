<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $barang = Barang::all();

        $cart = $request->session()->get('cart', []);
        $jumlahKeranjang = array_sum($cart);

        return view('barang.index', compact(
            'barang',
            'jumlahKeranjang'
        ));
    }

    public function tambah(Request $request, Barang $barang)
    {
        $cart = $request->session()->get('cart', []);

        $jumlahSekarang = $cart[$barang->id] ?? 0;

    if ($jumlahSekarang >= $barang->stok) {
        return redirect()
            ->route('barang.index')
            ->with('error', 'Jumlah barang sudah mencapai stok yang tersedia.');
    }

    $cart[$barang->id] = $jumlahSekarang + 1;

    $request->session()->put('cart', $cart);

    return redirect()
        ->route('barang.index')
        ->with('success', $barang->nama . ' berhasil dimasukkan ke keranjang.');
    }

    public function keranjang(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $barang = Barang::whereIn('id', array_keys($cart))->get();
        $items = $barang->map(function ($item) use ($cart)
        {
            $item->jumlah = $cart[$item->id];
            $item->subtotal = $item->harga * $item->jumlah;

            return $item;
        });
        $total = $items->sum('subtotal');

        return view('barang.keranjang', compact('items', 'total'));
    }

        public function ubahJumlah(Request $request, Barang $barang) 
        {
            $cart = $request->session()->get('cart', []); 
            $jumlahSekarang = $cart[$barang->id] ?? 0; 
            $aksi = $request->input('aksi'); 
            
            if ($aksi === 'tambah') 
            { 
                if ($jumlahSekarang >= $barang->stok) 
                { 
                    return redirect() 
                    ->route('keranjang.index') 
                    ->with('error', 'Jumlah barang sudah mencapai stok.'); 
                    } 
                    $cart[$barang->id] = $jumlahSekarang + 1; 
            } elseif ($aksi === 'kurang') 
                { 
                    if ($jumlahSekarang <= 1) 
                        { 
                            unset($cart[$barang->id]); 
                        } else 
                            { 
                                $cart[$barang->id] = $jumlahSekarang - 1; 
                            } 
                    } 
                    $request->session()->put('cart', $cart); 
                    return redirect() 
                    ->route('keranjang.index') 
                    ->with('success', 'Jumlah barang berhasil diperbarui.');
                    
                    
        }
    public function hapus(Request $request, Barang $barang)
    {
        $cart = $request->session()->get('cart', []);

        unset($cart[$barang->id]);

        $request->session()->put('cart', $cart);

        return redirect()
            ->route('keranjang.index')
            ->with('success', 'Barang berhasil dihapus dari keranjang.');
    }

    public function kosongkan(Request $request)
    {
        $request->session()->forget('cart');

        return redirect()
            ->route('keranjang.index')
            ->with('success', 'Keranjang berhasil dikosongkan.');
    }

   
}
