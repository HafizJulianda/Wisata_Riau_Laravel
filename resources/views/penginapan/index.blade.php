@extends('layouts.app')

@section('title', 'Penginapan')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Penginapan</h5>
        <button class="btn btn-pandan" data-bs-toggle="modal" data-bs-target="#formModal" onclick="openForm()">
            <i class="bi bi-plus-circle me-1"></i> Tambah Penginapan
        </button>
    </div>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3">
                    <select name="kolom" class="form-select" required>
                        <option value="">-- Cari Berdasarkan --</option>
                        <option value="nama_penginapan" {{ request('kolom') == 'nama_penginapan' ? 'selected' : '' }}>
                            Nama</option>
                        <option value="deskripsi_singkat"
                            {{ request('kolom') == 'deskripsi_singkat' ? 'selected' : '' }}>Deskripsi</option>
                        <option value="tipe" {{ request('kolom') == 'tipe' ? 'selected' : '' }}>Tipe</option>
                        <option value="fasilitas" {{ request('kolom') == 'fasilitas' ? 'selected' : '' }}>Fasilitas
                        </option>
                        <option value="harga_per_malam" {{ request('kolom') == 'harga_per_malam' ? 'selected' : '' }}>
                            Harga</option>
                        <option value="alamat" {{ request('kolom') == 'alamat' ? 'selected' : '' }}>Alamat</option>
                        <option value="kota_kabupaten" {{ request('kolom') == 'kota_kabupaten' ? 'selected' : '' }}>
                            Kabupaten</option>
                        <option value="jarak_ke_wisata" {{ request('kolom') == 'jarak_ke_wisata' ? 'selected' : '' }}>
                            Jarak</option>
                        <option value="rating" {{ request('kolom') == 'rating' ? 'selected' : '' }}>Rating</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control"
                        placeholder="Masukkan kata kunci...">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Cari</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('penginapan.index') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            </form>

            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Gambar</th>
                        <th>Deskripsi</th>
                        <th>Tipe</th>
                        <th>Fasilitas</th>
                        <th>Harga</th>
                        <th>Alamat</th>
                        <th>Kabupaten</th>
                        <th>Jarak</th>
                        <th>Rating</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penginapan as $i => $p)
                    <tr>
                        <td>{{ $i + $penginapan->firstItem() }}</td>
                        <td>{{ $p->nama_penginapan }}</td>
                        <td><img src="{{ $p->url_gambar }}" alt="gambar" width="100" class="img-thumbnail"></td>
                        <td>{{ $p->deskripsi_singkat }}</td>
                        <td>{{ $p->tipe }}</td>
                        <td>{{ $p->fasilitas }}</td>
                        <td>{{ $p->harga_per_malam }}</td>
                        <td>{{ $p->alamat }}</td>
                        <td>{{ $p->kota_kabupaten }}</td>
                        <td>{{ $p->jarak_ke_wisata }} </td>
                        <td>
                            <span class="badge bg-success">{{ $p->rating }} <i class="bi bi-star-fill"></i></span>
                        </td>
                        <td class="d-flex justify-content-around">
                            <button class="btn btn-sm btn-warning me-1" onclick='editData(@json($p))'>
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <form action="{{ route('penginapan.destroy', $p->id_penginapan) }}" method="POST"
                                style="display:inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Menampilkan data {{ $penginapan->firstItem() }} sampai {{ $penginapan->lastItem() }} dari total
                {{ $penginapan->total() }}
            </div>
            <nav>
                <ul class="pagination mb-0">
                    @if ($penginapan->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">Previous</span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $penginapan->previousPageUrl() }}" rel="prev">Previous</a>
                    </li>
                    @endif

                    @for ($i = 1; $i <= $penginapan->lastPage(); $i++)
                        <li class="page-item {{ $penginapan->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $penginapan->url($i) }}">{{ $i }}</a>
                        </li>
                        @endfor

                        @if ($penginapan->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $penginapan->nextPageUrl() }}" rel="next">Next</a>
                        </li>
                        @else
                        <li class="page-item disabled">
                            <span class="page-link">Next</span>
                        </li>
                        @endif
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Modal Form -->
<div class="modal fade" id="formModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="formData" method="POST">
            @csrf
            <input type="hidden" name="_method" id="_method" value="POST">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Form Penginapan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <input type="hidden" name="id" id="id_penginapan">
                    <div class="col-md-6">
                        <label class="form-label">Nama Penginapan</label>
                        <input type="text" name="nama_penginapan" id="nama_penginapan" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Deskripsi Singkat</label>
                        <input type="text" name="deskripsi_singkat" id="deskripsi_singkat" class="form-control"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Lokasi Wisata</label>
                        <input type="text" name="lokasi_wisata" id="lokasi_wisata" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tipe</label>
                        <input type="text" name="tipe" id="tipe" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Fasilitas</label>
                        <input type="text" name="fasilitas" id="fasilitas" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Harga Per Malam</label>
                        <input type="text" name="harga_per_malam" id="harga_per_malam" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" id="alamat" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kota/Kabupaten</label>
                        <input type="text" name="kota_kabupaten" id="kota_kabupaten" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jarak ke Wisata (km)</label>
                        <input type="text" name="jarak_ke_wisata" id="jarak_ke_wisata" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Rating</label>
                        <input type="number" step="0.1" name="rating" id="rating" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">URL Gambar</label>
                        <input type="url" name="url_gambar" id="url_gambar" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-pandan">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function openForm() {
    document.getElementById('formData').reset();
    document.getElementById('_method').value = 'POST';
    document.getElementById('formData').action = '{{ route("penginapan.store") }}';
}

function editData(data) {
    const modal = new bootstrap.Modal(document.getElementById('formModal'));
    modal.show();

    document.getElementById('_method').value = 'PUT';
    document.getElementById('formData').action = `/penginapan/${data.id_penginapan}`;

    document.getElementById('id_penginapan').value = data.id_penginapan;
    document.getElementById('nama_penginapan').value = data.nama_penginapan;
    document.getElementById('deskripsi_singkat').value = data.deskripsi_singkat;
    document.getElementById('lokasi_wisata').value = data.lokasi_wisata;
    document.getElementById('tipe').value = data.tipe;
    document.getElementById('fasilitas').value = data.fasilitas;
    document.getElementById('harga_per_malam').value = data.harga_per_malam;
    document.getElementById('alamat').value = data.alamat;
    document.getElementById('kota_kabupaten').value = data.kota_kabupaten;
    document.getElementById('jarak_ke_wisata').value = data.jarak_ke_wisata;
    document.getElementById('rating').value = data.rating;
    document.getElementById('url_gambar').value = data.url_gambar;
}
</script>
@endsection