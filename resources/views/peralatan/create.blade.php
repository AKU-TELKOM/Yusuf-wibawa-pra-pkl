<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Peralatan Lab - TEFA PPLG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-dark">

    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white py-3">
                <h5 class="card-title mb-0 fw-bold">Form Tambah Alat Lab Baru</h5>
            </div>
            <div class="card-body p-4">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('peralatan.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Peralatan</label>
                        <input type="text" name="nama_peralatan" class="form-control" placeholder="Contoh: Solder, Multimeter, Laptop" value="{{ old('nama_peralatan') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <input type="text" name="kategori" class="form-control" placeholder="Contoh: Elektronik, Komputer, Alat Ukur" value="{{ old('kategori') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Jumlah Stok Awal</label>
                        <input type="number" name="jumlah_stok" class="form-control" min="1" placeholder="Masukkan angka jumlah barang" value="{{ old('jumlah_stok') }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Kondisi Alat</label>
                        <select name="kondisi" class="form-select" required>
                            <option value="Bagus" {{ old('kondisi') == 'Bagus' ? 'selected' : '' }}>Bagus (Siap Pakai)</option>
                            <option value="Rusak Ringan" {{ old('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between border-top pt-3">
                        <a href="{{ route('peralatan.index') }}" class="btn btn-outline-secondary px-4">← Batal</a>
                        <button type="submit" class="btn btn-success px-4 shadow-sm">Simpan Alat</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
