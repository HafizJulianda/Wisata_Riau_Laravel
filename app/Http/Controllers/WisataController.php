<?php

namespace App\Http\Controllers;

use App\Models\Wisata;
use Illuminate\Http\Request;

class WisataController extends Controller
{
    public function index(Request $request)
    {
        $query = Wisata::query();

        // Pencarian berdasarkan kolom
        if ($request->filled('kolom') && $request->filled('keyword')) {
            $kolom = $request->kolom;
            $keyword = $request->keyword;

            $allowed = ['nama_wisata', 'deskripsi', 'alamat', 'jam_buka', 'kabupaten_kota', 'rating'];
            if (in_array($kolom, $allowed)) {
                $query->where($kolom, 'like', "%$keyword%");
            }
        }

        $wisata = $query->paginate(10)->withQueryString();

        // Tambahkan field deskripsi_pendek (tanpa gunakan Str::limit)
        foreach ($wisata as $item) {
            $item->deskripsi_pendek = strlen($item->deskripsi) > 50
                ? substr($item->deskripsi, 0, 47) . '...'
                : $item->deskripsi;
        }

        return view('wisata.index', compact('wisata'));
    }

    public function create()
    {
        return back();
    }

    public function store(Request $request)
    {
        Wisata::create($request->all());
        return redirect()->route('wisata.index')->with('success', 'Wisata berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = Wisata::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = Wisata::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('wisata.index')->with('success', 'Wisata berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Wisata::findOrFail($id)->delete();
        return redirect()->route('wisata.index')->with('success', 'Wisata berhasil dihapus!');
    }
}
