<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Alat Lab TEFA</title>
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
                                <th>Nama Alat</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($loans as $index => $loan)
                                <tr>
                                    <td class="ps-3">{{ $loans->firstItem() + $index }}</td>
                                    <td><strong>{{ $loan->user->name }}</strong><br><small class="text-muted">{{ $loan->user->email }}</small></td>
                                    <td><span class="badge bg-secondary">{{ $loan->equipment->kode_alat }}</span> {{ $loan->equipment->nama_alat }}</td>
                                    <td>{{ $loan->tanggal_pinjam->format('d M Y') }}</td>
                                    <td>{{ $loan->tanggal_kembali ? $loan->tanggal_kembali->format('d M Y') : '-' }}</td>
                                    <td>
                                        @if($loan->status === 'dipinjam')
                                            <span class="badge bg-warning text-dark">Dipinjam</span>
                                        @else
                                            <span class="badge bg-success">Dikembalikan</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($loan->status === 'dipinjam')
                                            <form action="{{ route('loans.return', $loan->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success">Kembalikan Alat</button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('loans.destroy', $loan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus log transaksi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Belum ada data transaksi peminjaman.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{ $loans->links() }}
        </div>
    </div>

    <div class="modal fade" id="modalPinjam" tabindex="-1" aria-labelledby="modalPinjamLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPinjamLabel">Catat Transaksi Peminjaman Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('loans.store') }}" method="POST">
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
                            <label for="user_id" class="form-label">Nama Peminjam (Siswa/Admin)</label>
                            <select class="form-select" name="user_id" id="user_id" required>
                                <option value="" selected disabled>-- Pilih Peminjam --</option>
                                @foreach(\App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ ucfirst($user->role) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="equipment_id" class="form-label">Peralatan Lab TEFA</label>
                            <select class="form-select" name="equipment_id" id="equipment_id" required>
                                <option value="" selected disabled>-- Pilih Alat --</option>
                                @foreach(\App\Models\Equipment::all() as $equipment)
                                    <option value="{{ $equipment->id }}" {{ old('equipment_id') == $equipment->id ? 'selected' : '' }} {{ $equipment->stok < 1 ? 'disabled' : '' }}>
                                        {{ $equipment->kode_alat }} - {{ $equipment->nama_alat }} (Stok: {{ $equipment->stok }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                            <input type="date" class="form-control" name="tanggal_pinjam" id="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
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

    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var myModal = new bootstrap.Modal(document.getElementById('modalPinjam'));
                myModal.show();
            });
        </script>
    @endif
</body>
</html>