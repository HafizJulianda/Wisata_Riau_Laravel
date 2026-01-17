<?php

namespace App\Http\Controllers;

use App\Models\Penginapan;
use Illuminate\Http\Request;

class PenginapanController extends Controller
{
    public function index(Request $request)
    {
        $query = Penginapan::query();
    
        if ($request->filled('kolom') && $request->filled('keyword')) {
            $kolom = $request->kolom;
            $keyword = $request->keyword;
    
            // Validasi kolom supaya tidak sembarangan (whitelist kolom yang boleh dicari)
            $allowed = ['nama_penginapan', 'deskripsi_singkat', 'tipe', 'fasilitas', 'harga_per_malam', 'alamat', 'kota_kabupaten', 'jarak_ke_wisata', 'rating'];
    
            if (in_array($kolom, $allowed)) {
                $query->where($kolom, 'like', "%$keyword%");
            }
        }
    
        $penginapan = $query->paginate(10);
    
        return view('penginapan.index', compact('penginapan'));
    }
    


    public function create()
    {
        return view('penginapan.create');
    }

    public function store(Request $request)
    {
        Penginapan::create($request->all());
        return redirect()->route('penginapan.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Penginapan::findOrFail($id);
        return view('penginapan.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Penginapan::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('penginapan.index')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        $data = Penginapan::findOrFail($id);
        $data->delete();
        return redirect()->route('penginapan.index')->with('success', 'Data berhasil dihapus');
    }
}