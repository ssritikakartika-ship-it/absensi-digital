<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $classes = ClassModel::all();
        $query = Student::with('class');

        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%');
        }

        $students = $query->paginate(10);

        return view('siswa', compact('students', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis'      => 'required|unique:students,nis',
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'class_id' => 'required',
        ]);

        // 1. Buatkan akun User khusus untuk siswa baru ini
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make('siswa123'), // Password bawaan untuk siswa
            'role'     => 'siswa',
        ]);

        // 2. Simpan data siswa dan hubungkan dengan user_id yang baru dibuat
        Student::create([
            'user_id'  => $user->id,
            'nis'      => $request->nis,
            'nama'     => $request->name,
            'class_id' => $request->class_id,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa dan akun login berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'nis'      => 'required|unique:students,nis,' . $id,
            'name'     => 'required',
            'class_id' => 'required',
        ]);

        $student->update([
            'nis'      => $request->nis,
            'nama'     => $request->name,
            'class_id' => $request->class_id,
        ]);

        // Jika siswa terhubung ke tabel users, update nama di tabel users juga
        if ($student->user) {
            $student->user->update([
                'name' => $request->name,
            ]);
        }

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        // Hapus akun User terkait jika ada
        if ($student->user) {
            $student->user->delete();
        }

        $student->delete();

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus!');
    }
}