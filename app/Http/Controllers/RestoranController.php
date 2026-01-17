<?php

namespace App\Http\Controllers;

use App\Models\Restoran;
use Illuminate\Http\Request;

class RestoranController extends Controller
{
    public function index(Request $request)
{
    $query = Restoran::query();

    if ($request->filled('kolom') && $request->filled('keyword')) {
        $kolom = $request->kolom;
        $keyword = $request->keyword;

        $allowed = ['nama_restoran', 'tipe', 'alamat', 'harga', 'jam_operasional', 'kabupaten_kota', 'jarak', 'rating'];

        if (in_array($kolom, $allowed)) {
            $query->where($kolom, 'like', "%$keyword%");
        }
    }

    $restoran = $query->paginate(10);

    return view('restoran.index', compact('restoran'));
}


    public function create()
    {
        return back();
    }

    public function store(Request $request)
    {
        Restoran::create($request->all());
        return redirect()->route('restoran.index')->with('success', 'Restoran berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = Restoran::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = Restoran::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('restoran.index')->with('success', 'Restoran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Restoran::findOrFail($id)->delete();
        return redirect()->route('restoran.index')->with('success', 'Restoran berhasil dihapus!');
    }
}