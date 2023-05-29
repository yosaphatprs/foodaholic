<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            return view('admin.home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function mitra(Request $request)
    {
        $search = $request->query('search');

        $mitra = Mitra::where('nama_mitra', 'LIKE', "%{$search}%")
            ->orderBy('id', 'DESC')
            ->paginate(10)->withQueryString();

        return view('admin.mitra', compact('mitra'));
    }

    public function detail_mitra($id)
    {
        $mitra = Mitra::find($id);
        return view('admin.detail_mitra', ['mitra' => $mitra]);
    }


    public function terima_mitra($id)
    {
        $mitra = Mitra::find($id);
        $mitra->status_verifikasi = 1;
        $mitra->save();
        return redirect('/admin/mitra/detail/' . $id);
    }

    public function tolak_mitra($id)
    {
        $mitra = Mitra::find($id);
        $mitra->status_verifikasi = 2;
        $mitra->save();
        return redirect('/admin/mitra/detail/' . $id);
    }

    public function hapus_verifikasi($id)
    {
        $mitra = Mitra::find($id);
        $mitra->status_verifikasi = 0;
        $mitra->save();
        return redirect('/admin/mitra/detail/' . $id);
    }

    public function show_produk($id)
    {
        $produk = Produk::where('id_mitra', $id)->get();
        $paginate = Produk::paginate(5);
        return view('admin.produk', ['produk' => $produk, 'paginate' => $paginate]);
    }

    public function transaksi()
    {
        $transaksi = Transaksi::with('user', 'produk', 'mitra')->paginate(5);
        return view('admin.transaksi', ['transaksi' => $transaksi]);
    }
}