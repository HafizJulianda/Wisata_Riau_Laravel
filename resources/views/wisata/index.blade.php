@extends('layouts.app')

@section('title', 'Wisata')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Wisata</h5>
        <button class="btn btn-pandan" data-bs-toggle="modal" data-bs-target="#wisataModal" onclick="openWisataForm()">
            <i class="bi bi-plus-circle me-1"></i> Tambah Wisata
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
                        <option value="nama_wisata" {{ request('kolom') == 'nama_wisata' ? 'selected' : '' }}>Nama
                            Wisata</option>
                        <option value="deskripsi" {{ request('kolom') == 'deskripsi' ? 'selected' : '' }}>Deskripsi
                        </option>
                        <option value="alamat" {{ request('kolom') == 'alamat' ? 'selected' : '' }}>Alamat</option>
                        <option value="jam_buka" {{ request('kolom') == 'jam_buka' ? 'selected' : '' }}>Jam Buka
                        </option>
                        <option value="kabupaten_kota" {{ request('kolom') == 'kabupaten_kota' ? 'selected' : '' }}>
                            Kabupaten/Kota</option>
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
                    <a href="{{ route('wisata.index') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            </form>

            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Wisata</th>
                        <th>Deskripsi</th>
                        <th>Alamat</th>
                        <th>Jam Buka</th>
                        <th>Kab/Kota</th>
                        <th>Rating</th>
                        <th>Map</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($wisata as $key => $w)
                    <tr>
                        <td>{{ $wisata->firstItem() + $key }}</td>
                        <td><img src="{{ $w->url_gambar }}" alt="gambar" width="100" class="img-thumbnail"></td>
                        <td>{{ $w->nama_wisata }}</td>
                        <td>{{ $w->deskripsi }}</td>
                        <td>{{ $w->alamat }}</td>
                        <td>{{ $w->jam_buka }}</td>
                        <td>{{ $w->kabupaten_kota }}</td>
                        <td>
                            <span class="badge bg-success">{{ $w->rating }} <i class="bi bi-star-fill"></i></span>
                        </td>
                        <td>
                            <a href="{{ $w->url_alamat }}" class="btn btn-sm btn-info" target="_blank">
                                <i class="bi bi-map"></i> Lihat
                            </a>
                        </td>
                        <td class="d-flex justify-content-around">
                            <button class="btn btn-warning btn-sm me-1" onclick='editWisata(@json($w))'>
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <form action="{{ route('wisata.destroy', $w->id_wisata) }}" method="POST"
                                style="display:inline;">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Hapus?')" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Menampilkan data {{ $wisata->firstItem() }} sampai {{ $wisata->lastItem() }} dari total
                {{ $wisata->total() }}
            </div>
            <nav>
                <ul class="pagination mb-0">
                    @if ($wisata->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">Previous</span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $wisata->previousPageUrl() }}" rel="prev">Previous</a>
                    </li>
                    @endif

                    @for ($i = 1; $i <= $wisata->lastPage(); $i++)
                        <li class="page-item {{ $wisata->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $wisata->url($i) }}">{{ $i }}</a>
                        </li>
                        @endfor

                        @if ($wisata->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $wisata->nextPageUrl() }}" rel="next">Next</a>
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

<!-- Modal Form Wisata -->
<div class="modal fade" id="wisataModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="wisataForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="wisata_method" value="POST">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Form Wisata</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <input type="hidden" name="id_wisata" id="id_wisata">
                    <div class="col-md-6">
                        <label class="form-label">Nama Wisata</label>
                        <input type="text" name="nama_wisata" id="nama_wisata" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jam Buka</label>
                        <input type="text" name="jam_buka" id="jam_buka" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kabupaten/Kota</label>
                        <input type="text" name="kabupaten_kota" id="kabupaten_kota" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Rating</label>
                        <input type="number" step="0.1" name="rating" id="rating" class="form-control" min="0" max="5"
                            required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" id="alamat" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">URL Alamat (Map)</label>
                        <input type="url" name="url_alamat" id="url_alamat" class="form-control" required>
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
function openWisataForm() {
    document.getElementById('wisataForm').reset();
    document.getElementById('wisata_method').value = 'POST';
    document.getElementById('wisataForm').action = '{{ route("wisata.store") }}';
    document.getElementById('id_wisata').value = '';
}

function editWisata(data) {
    const modal = new bootstrap.Modal(document.getElementById('wisataModal'));
    modal.show();

    document.getElementById('wisata_method').value = 'PUT';
    document.getElementById('wisataForm').action = `/wisata/${data.id_wisata}`;

    // Set nilai form sesuai data
    document.getElementById('id_wisata').value = data.id_wisata;
    document.getElementById('nama_wisata').value = data.nama_wisata;
    document.getElementById('jam_buka').value = data.jam_buka;
    document.getElementById('kabupaten_kota').value = data.kabupaten_kota;
    document.getElementById('rating').value = data.rating;
    document.getElementById('deskripsi').value = data.deskripsi;
    document.getElementById('alamat').value = data.alamat;
    document.getElementById('url_alamat').value = data.url_alamat;
    document.getElementById('url_gambar').value = data.url_gambar;
}
</script>
@endsection