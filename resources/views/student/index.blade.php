@extends('layouts/admin')

@push('title', 'Halaman Siswa')


@section('content')
    <div class="card">
        <div class="card-header">
            Data Siswa


            <a href="/student/add" type="button" class="btn btn-primary float-right mr-2">
                <i class="fas fa-plus mr-2"></i>Tambah</a>

        </div>

        <div class="card-body">
            {{-- @if (session('notifikasi'))
        <div class="alert alert-{{ session('type') }}">
            {{ session('notifikasi') }}
        </div>
        @endif --}}

            <div class="table-responsive">

                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <td>No.</td>
                        <td>NIM</td>
                        <td>Nama</td>
                        <td>Prodi</td>
                        <td>Foto</td>
                        <td>#</td>
                    </thead>


                    <tbody>

                        @forelse ($students as $index => $data)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $data->nim }}</td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->prodi }}</td>

                                <td>
                                    <img class="img-fluid" src="{{ asset('storage/' . $data->foto) }}">
                                </td>


                                <td>

                                    <a href="/student/edit/{{ $data->nim }}"
                                        class="btn btn-sm btn-warning 
                                mx-1 my-1"><i
                                            class="fas fa-pencil-alt mr-2"></i>Edit</a>

                                    <form method="POST" action="/student/delete/{{ $data->nim }}">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm btn-danger 
                                mx-1 my-1"><i
                                                class="fas fa-trash-alt mr-2"></i>Hapus</button>
                                    </form>


                                    <a href="/student/download/{{ $data->nim }}"
                                        class="btn btn-sm btn-primary 
                                mx-1 my-1"><i
                                            class="fas fa-file-download mr-2"></i>Download</a>

                                    <a href="/student/preview/{{ $data->nim }}"
                                        class="btn btn-sm btn-info 
                                    mx-1 my-1"><i
                                            class="fas fa-eye mr-2"></i>Preview</a>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="100%">Tidak ada data untuk ditampilkan !</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>

    </div>
@endsection
