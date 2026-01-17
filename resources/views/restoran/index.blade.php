@extends('layouts.app')

@section('title', 'Restoran')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Restoran</h5>
        <button class="btn btn-pandan" data-bs-toggle="modal" data-bs-target="#restoranModal"
            onclick="openRestoranForm()">
            <i class="bi bi-plus-circle me-1"></i> Tambah Restoran
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
                        <option value="nama_restoran" {{ request('kolom') == 'nama_restoran' ? 'selected' : '' }}>Nama
                            Restoran</option>
                        <option value="tipe" {{ request('kolom') == 'tipe' ? 'selected' : '' }}>Tipe</option>
                        <option value="alamat" {{ request('kolom') == 'alamat' ? 'selected' : '' }}>Alamat</option>
                        <option value="harga" {{ request('kolom') == 'harga' ? 'selected' : '' }}>Harga</option>
                        <option value="jam_operasional" {{ request('kolom') == 'jam_operasional' ? 'selected' : '' }}>
                            Jam Operasional</option>
                        <option value="kabupaten_kota" {{ request('kolom') == 'kabupaten_kota' ? 'selected' : '' }}>
                            Kabupaten/Kota</option>
                        <option value="jarak" {{ request('kolom') == 'jarak' ? 'selected' : '' }}>Jarak</option>
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
                    <a href="{{ route('restoran.index') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            </form>

            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Restoran</th>
                        <th>Tipe</th>
                        <th>Alamat</th>
                        <th>Harga</th>
                        <th>Jam Operasional</th>
                        <th>Kabupaten/Kota</th>
                        <th>Jarak</th>
                        <th>Rating</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($restoran as $i => $r)
                    <tr>
                        <td>{{ $restoran->firstItem() + $i }}</td>
                        <td><img src="{{ $r->url_gambar }}" alt="gambar" width="100" class="img-thumbnail"></td>
                        <td>{{ $r->nama_restoran }}</td>
                        <td>{{ $r->tipe }}</td>
                        <td>{{ $r->alamat }}</td>
                        <td>{{ $r->harga }}</td>
                        <td>{{ $r->jam_operasional }}</td>
                        <td>{{ $r->kabupaten_kota }}</td>
                        <td>{{ $r->jarak }} </td>
                        <td>
                            <span class="badge bg-success">{{ $r->rating }} <i class="bi bi-star-fill"></i></span>
                        </td>
                        <td class="d-flex justify-content-around">
                            <button class="btn btn-sm btn-warning me-1" onclick='editRestoran(@json($r))'>
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <form action="{{ route('restoran.destroy', $r->id_restoran) }}" method="POST"
                                style="display:inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Hapus?')" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="text-muted">
            Menampilkan data {{ $restoran->firstItem() }} sampai {{ $restoran->lastItem() }} dari total
            {{ $restoran->total() }}
        </div>
        <nav>
            <ul class="pagination mb-0">
                @if ($restoran->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">Previous</span>
                </li>
                @else
                <li class="page-item">
                    <a class="page-link" href="{{ $restoran->previousPageUrl() }}" rel="prev">Previous</a>
                </li>
                @endif

                @for ($i = 1; $i <= $restoran->lastPage(); $i++)
                    <li class="page-item {{ $restoran->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $restoran->url($i) }}">{{ $i }}</a>
                    </li>
                    @endfor

                    @if ($restoran->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $restoran->nextPageUrl() }}" rel="next">Next</a>
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

<!-- Modal Form Restoran -->
<div class="modal fade" id="restoranModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="restoranForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="restoran_method" value="POST">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Form Restoran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <input type="hidden" name="id_restoran" id="id_restoran">
                    <div class="col-md-6">
                        <label class="form-label">Nama Restoran</label>
                        <input type="text" name="nama_restoran" id="nama_restoran" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tipe</label>
                        <input type="text" name="tipe" id="tipe" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" id="alamat" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" id="harga" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jam Operasional</label>
                        <input type="text" name="jam_operasional" id="jam_operasional" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kabupaten/Kota</label>
                        <input type="text" name="kabupaten_kota" id="kabupaten_kota" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jarak (km)</label>
                        <input type="number" step="0.1" name="jarak" id="jarak" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Rating</label>
                        <input type="number" step="0.1" name="rating" id="rating" class="form-control" min="0" max="5"
                            required>
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
function openRestoranForm() {
    document.getElementById('restoranForm').reset();
    document.getElementById('restoran_method').value = 'POST';
    document.getElementById('restoranForm').action = '{{ route("restoran.store") }}';
    document.getElementById('id_restoran').value = '';
}

function editRestoran(data) {
    const modal = new bootstrap.Modal(document.getElementById('restoranModal'));
    modal.show();

    document.getElementById('restoran_method').value = 'PUT';
    document.getElementById('restoranForm').action = `/restoran/${data.id_restoran}`;

    // Set nilai form sesuai data
    document.getElementById('id_restoran').value = data.id_restoran;
    document.getElementById('nama_restoran').value = data.nama_restoran;
    document.getElementById('tipe').value = data.tipe;
    document.getElementById('alamat').value = data.alamat;
    document.getElementById('harga').value = data.harga;
    document.getElementById('jam_operasional').value = data.jam_operasional;
    document.getElementById('kabupaten_kota').value = data.kabupaten_kota;
    document.getElementById('jarak').value = data.jarak;
    document.getElementById('rating').value = data.rating;
    document.getElementById('url_gambar').value = data.url_gambar;
}
</script>
@endsection