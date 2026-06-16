@extends('layouts/admin')

@push('title', 'Halaman Tambah Siswa')

@section('content')

<div class="card">
    <div class="card-header">
        Tambah Siswa

        <a href="/student" type="button" class="btn btn-danger float-right">Kembali</a>
    </div>

    <form action="/student/add" method="POST" enctype="multipart/form-data">
        @csrf


        <div class="card-body">

            @if(session('notifikasi'))
            <div class="form-group">

                <div class="alert alert-{{ session('type') }}">
                    {{ session('notifikasi') }}
                </div>
            </div>
            @endif

            <div class="form-group">
                <label for="nama">NIM <b class="text-danger">*</b></label>
                <input required placeholder="Masukkan NIM" type="text" id="nim" name="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim') }}">
                @error('nim')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama">Nama <b class="text-danger">*</b></label>
                <input required placeholder="Masukkan Nama" type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
                @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama">E-Mail <b class="text-danger">*</b></label>
                <input required placeholder="Masukkan E-Mail" type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- New Line --}}
            <div class="form-group">
                <label for="nama">Foto <b class="text-danger">*</b></label>
                <input required placeholder="Upload Foto" type="file" accept="image/png, image/jpg, image/jpeg" id="foto" name="foto" class="form-control @error('foto') is-invalid @enderror" onchange="check_upload(this)">
                @error('foto')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>




            <div class="form-group">
                <label for="nama">Prodi <b class="text-danger">*</b></label>
                <select id="prodi" name="prodi" class="form-control @error('prodi') is-invalid @enderror" required>
                    <option value="">- Pilih Prodi -</option>
                    <option value="Teknik Informatika" {{ old('prodi')=='Teknik Informatika' ? 'selected' : '' }}>Teknik
                        Informatika</option>
                    <option value="Teknik Rekayasa Keamanan Siber" {{ old('prodi')=='Teknik Rekayasa Keamanan Siber'
                        ? 'selected' : '' }}>Teknik Rekayasa Keamanan Siber</option>
                    <option value="Teknik Rekayasa Perangkat Lunak" {{ old('prodi')=='Teknik Rekayasa Perangkat Lunak'
                        ? 'selected' : '' }}>Teknik Rekayasa Perangkat Lunak</option>
                </select>

                @error('prodi')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>
        <div class="card-footer">
            <a href="/student" class="btn btn-danger">Batal</a>
            <button type="reset" class="btn btn-warning">Reset</button>
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
    </form>



</div>
@endsection

@push('addon-script-footer')

<script>
    function check_upload(input) {
        let allowed_types = input.accept.split(",");
        allowed_types = allowed_types.map((type) => type.trim());
        const default_types = ["image/png", "image/jpg", "image/jpeg"];
        allowed_types = allowed_types.length ? allowed_types : default_types;
        const max_size = 2 * 1024 * 1024; // 2MB

        if (input.files && input.files[0]) {
            const file = input.files[0];
            // Check file type
            if (!allowed_types.includes(file.type)) {
                alert("Tipe file tidak diterima.");
                input.value = ""; // Reset input
                return;
            }
            // Check file size
            if (file.size > max_size) {
                alert("Ukuran file melebihi batas maksimum 2MB.");
                input.value = ""; // Reset input
                return;
            }
        }
    }

</script>

@endpush
