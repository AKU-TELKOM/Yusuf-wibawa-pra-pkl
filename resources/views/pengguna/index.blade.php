<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna - TEFA PPLG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-dark">

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">Daftar Pengguna / Peminjam Lab</h2>
            <a href="{{ route('pengguna.create') }}" class="btn btn-primary shadow-sm">+ Tambah Pengguna Baru</a>
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
                                <th class="py-3">Nama Lengkap</th>
                                <th class="py-3">Kelas</th>
                                <th class="py-3">Jurusan</th>
                                <th class="py-3">No. Handphone</th>
                                <th class="py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengguna as $p)
                            <tr>
                                <td class="px-4"><strong>{{ $p->id }}</strong></td>
                                <td>{{ $p->nama }}</td>
                                <td><span class="badge bg-secondary">{{ $p->kelas }}</span></td>
                                <td>{{ $p->jurusan }}</td>
                                <td>{{ $p->no_hp }}</td>
                                <td class="text-center">
                                    <form action="{{ route('pengguna.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger px-3 rounded-pill">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <p class="mb-0">Belum ada data pengguna di dalam database `tefa_pplg`.</p>
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
            <a href="{{ url('/peralatan') }}" class="btn btn-outline-secondary">Menu Inventaris Alat</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
