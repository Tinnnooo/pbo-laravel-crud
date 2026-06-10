<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();

        return view('student.index', ['students' => $students]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nim' => 'required|unique:students,nim',
            'nama' => 'required',
            'email' => 'required|email',
            'prodi' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nim.required' => 'NIM harus diisi.',
            'nim.unique' => 'NIM sudah digunakan.',
            'nama.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'prodi.required' => 'Program studi harus diisi.',
            'foto.required' => 'Foto harus diisi.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'foto.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto')->store('foto', 'public');
            $foto = basename($file);
        } else {
            $foto = null;
        }

        $students = new Student;
        $students->nim = $validatedData['nim'];
        $students->nama = $validatedData['nama'];
        $students->email = $validatedData['email'];
        $students->prodi = $validatedData['prodi'];
        $students->foto = $foto ? 'foto/'.$foto : null;

        if ($students->save()) {
            return redirect('/student')->with([
                'notifikasi' => 'Data Berhasil disimpan !',
                'type' => 'success',
            ]);
        } else {
            return redirect()->back()->with([
                'notifikasi' => 'Data gagal disimpan !',
                'type' => 'error',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::where(['nim' => $id]);

        if ($student->count() < 1) {
            return redirect('/student')->with([
                'notifikasi' => 'Data siswa tidak ditemukan !',
                'type' => 'error',
            ]);
        }

        return view('student.edit', ['student' => $student->first()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::where('nim', $id)->firstOrFail();

        $validatedData = $request->validate([
            'nim' => [
                'required',
                'unique:students,nim,'.$request->old_nim.',nim',
            ],
            'nama' => 'required',
            'email' => 'required|email',
            'prodi' => 'required',
        ], [
            'nim.required' => 'NIM harus diisi.',
            'nim.unique' => 'NIM sudah digunakan.',
            'nama.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'prodi.required' => 'Program studi harus diisi.',
        ]);

        // Cek Apakah Ganti Foto
        if ($request->ganti_foto == 1) {
            $request->validate([
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ], [
                'foto.required' => 'Foto harus diupload.',
                'foto.image' => 'File harus berupa gambar.',
                'foto.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
                'foto.max' => 'Ukuran gambar maksimal 2MB.',
            ]);

            if ($request->hasFile('foto')) {
                $file = $request->file('foto')->store('foto', 'public');
                $foto = 'foto/'.basename($file);
            } else {
                $foto = null;
            }
        } else {
            $foto = $student->foto;
        }

        // Foto lama
        $old_foto = $student->foto;

        $student->nim = $request->nim;
        $student->nama = $request->nama;
        $student->email = $request->email;
        $student->prodi = $request->prodi;
        $student->foto = $foto ?? null;

        if ($student->save()) {
            // Hapus file foto lama jika ganti foto
            if ($request->ganti_foto == 1) {
                if (! empty($old_foto) && Storage::disk('public')->exists($old_foto)) {
                    Storage::disk('public')->delete($old_foto);
                }
            }

            return redirect('/student')->with([
                'notifikasi' => 'Data Berhasil diedit !',
                'type' => 'success',
            ]);
        } else {
            return redirect()->back()->with([
                'notifikasi' => 'Data gagal diedit !',
                'type' => 'error',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::where(['nim' => $id])->firstOrFail();

        $foto_siswa = $student->foto;

        if ($student->delete()) {
            if (! empty($foto_siswa) && Storage::disk('public')->exists($foto_siswa)) {
                Storage::disk('public')->delete($foto_siswa);
            }

            return redirect('/student')->with([
                'notifikasi' => 'Data Berhasil dihapus !',
                'type' => 'success',
            ]);
        } else {
            return redirect()->back()->with([
                'notifikasi' => 'Data gagal dihapus !',
                'type' => 'error',
            ]);
        }
    }

    /**
     * Download foto siswa.
     */
    public function download(string $id)
    {
        $student = Student::where('nim', $id)->firstOrFail();

        if (empty($student->foto) || ! Storage::disk('public')->exists($student->foto)) {
            return redirect()->back()->with([
                'notifikasi' => 'Foto tidak ditemukan !',
                'type' => 'error',
            ]);
        }

        $file_path = public_path('storage/').$student->foto;
        $file_name = 'foto-'.$student->nim.'.'.pathinfo($file_path, PATHINFO_EXTENSION);

        return response()->download($file_path, $file_name);
    }

    /**
     * Preview foto siswa.
     */
    public function preview(string $id)
    {
        $student = Student::where('nim', $id)->firstOrFail();

        if (empty($student->foto) || ! Storage::disk('public')->exists($student->foto)) {
            return redirect()->back()->with([
                'notifikasi' => 'Foto tidak ditemukan !',
                'type' => 'error',
            ]);
        }

        $file_path = public_path('storage/').$student->foto;

        return response()->file($file_path);
    }
}
