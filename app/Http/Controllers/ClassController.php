<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $query = ClassModel::withCount('students');

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_kelas', 'like', '%' . $request->search . '%');
        }

        $classes = $query->paginate(10);

        return view('kelas', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|unique:classes,nama_kelas',
        ]);

        ClassModel::create([
            'nama_kelas' => $request->nama_kelas,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|unique:classes,nama_kelas,' . $id,
        ]);

        $class = ClassModel::findOrFail($id);
        $class->update([
            'nama_kelas' => $request->nama_kelas,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $class = ClassModel::findOrFail($id);
        
        // Cek apakah kelas masih memiliki siswa
        if ($class->students()->count() > 0) {
            return redirect()->route('kelas.index')->with('error', 'Kelas tidak bisa dihapus karena masih memiliki siswa!');
        }

        $class->delete();

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil dihapus!');
    }
}