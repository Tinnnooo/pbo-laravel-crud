<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student | Laravel</title>

    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="container-fluid mt-4">
            <div class="card">
                <div class="card-header">
                    Data Siswa
                    <a href="/student/add" type="button" class="btn btn-primary float-right">Tambah</a>
                </div>

                <div class="card-body">
                    @if (session('notifikasi'))
                        <div class="alert alert-{{ session('type') }}">
                            {{ session('notifikasi') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <td>No.</td>
                                <td>NIM</td>
                                <td>Nama</td>
                                <td>Prodi</td>
                                <td>#</td>
                            </thead>

                            <tbody>
                                @forelse ($students as $index => $data)
                                    <tr>
                                        <td>
                                            {{ $index + 1 }}
                                        </td>
                                        <td>{{ $data->nim }}</td>
                                        <td>{{ $data->nama }}</td>
                                        <td>{{ $data->prodi }}</td>
                                        <td>
                                            <a href="/student/edit/{{ $data->nim }}"
                                                class="btn btn-warning btn-sm mr-1">
                                                <i class="bi bi-search"></i>
                                                Edit
                                            </a>
                                            <form method="POST" action="/student/delete/{{ $data->nim }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm mr-1">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%">Tidak ada data untuk di tampilkan !</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-4.0.0.slim.min.js"
        integrity="sha256-8DGpv13HIm+5iDNWw1XqxgFB4mj+yOKFNb+tHBZOowc=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"
        integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>
