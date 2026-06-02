<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Peminjaman Alat Lab TEFA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Log Peminjaman Peralatan Lab TEFA PPLG</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPinjam">Catat Pinjaman Baru</button>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-3">No</th>
                                <th>Nama Peminjam</th>
                                <th>Peralatan</th>
                                <th>Jumlah</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjamans as $index => $data)
                                <tr>
                                    <td class="ps-3">{{ $peminjamans->firstItem() + $index }}</td>
                                    <td><strong>{{ $data->pengguna->nama }}</strong><br><small class="text-muted">{{ $data->pengguna->kelas }} - {{ $data->pengguna->jurusan }}</small></td>
                                    <td><span class="badge bg-secondary">{{ $data->peralatan->kategori }}</span> {{ $data->peralatan->nama_peralatan }}</td>
                                    <td>{{ $data->jumlah_pinjam }} Unit</td>
                                    <td>{{ $data->tanggal_pinjam->format('d M Y') }}</td>
                                    <td>{{ $data->tanggal_kembali ? $data->tanggal_kembali->format('d M Y') : '-' }}</td>
                                    <td>
                                        @if(!$data->tanggal_kembali)
                                            <span class="badge bg-warning text-dark">Dipinjam</span>
                                        @else
                                            <span class="badge bg-success">Dikembalikan</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if(!$data->tanggal_kembali)
                                            <form action="{{ route('peminjaman.return', $data->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success">Kembalikan</button>
                                            </form>
                                        @endif
                                        <form action="{{ route('peminjaman.destroy', $data->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus transaksi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">Belum ada data transaksi peminjaman.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{ $peminjamans->links() }}
        </div>
    </div>

    <div class="modal fade" id="modalPinjam" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Catat Transaksi Peminjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('peminjaman.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Nama Peminjam</label>
                            <select class="form-select" name="pengguna_id" required>
                                <option value="" selected disabled>-- Pilih Anggota --</option>
                                @foreach(\App\Models\Pengguna::all() as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama }} ({{ $p->kelas }} {{ $p->jurusan }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Peralatan Lab</label>
                            <select class="form-select" name="peralatan_id" required>
                                <option value="" selected disabled>-- Pilih Alat --</option>
                                @foreach(\App\Models\Peralatan::all() as $a)
                                    <option value="{{ $a->id }}" {{ $a->jumlah_stok < 1 ? 'disabled' : '' }}>
                                        {{ $a->nama_peralatan }} (Stok: {{ $a->jumlah_stok }} | Kondisi: {{ $a->kondisi }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jumlah Pinjam</label>
                            <input type="number" class="form-control" name="jumlah_pinjam" value="1" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Pinjam</label>
                            <input type="date" class="form-control" name="tanggal_pinjam" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>