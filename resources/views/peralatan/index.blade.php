<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Peralatan - TEFA PPLG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-dark">

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-success">Inventaris Peralatan Lab</h2>
            <a href="{{ route('peralatan.create') }}" class="btn btn-success shadow-sm">+ Tambah Alat Baru</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th class="px-4 py-3">ID</th>
                                <th class="py-3">Nama Peralatan</th>
                                <th class="py-3">Kategori</th>
                                <th class="py-3">Jumlah Stok</th>
                                <th class="py-3">Kondisi</th>
                                <th class="py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peralatan as $alat)
                            <tr>
                                <td class="px-4"><strong>{{ $alat->id }}</strong></td>
                                <td class="fw-bold text-secondary">{{ $alat->nama_peralatan }}</td>
                                <td><span class="badge bg-secondary">{{ $alat->kategori }}</span></td>
                                <td><span class="fw-bold">{{ $alat->jumlah_stok }}</span> unit</td>
                                <td>
                                    <span class="badge {{ $alat->kondisi == 'Bagus' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ $alat->kondisi }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('peralatan.destroy', $alat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus alat ini dari inventaris?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger px-3 rounded-pill">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <p class="mb-0">Belum ada data peralatan di dalam database `tefa_pplg`.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <a href="{{ url('/peminjaman') }}" class="btn btn-outline-secondary">Menu Peminjaman</a>
            <a href="{{ url('/pengguna') }}" class="btn btn-outline-secondary">Menu Pengguna/Peminjam</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
