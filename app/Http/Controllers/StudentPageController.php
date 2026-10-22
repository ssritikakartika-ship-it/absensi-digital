<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StudentPageController extends Controller
{
    public function index()
    {
        $students = Student::with(['user', 'class'])
            ->latest()
            ->get();

        $classes = ClassModel::latest()->get();

        return view('students.index', compact('students', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nis' => 'required|string|max:255|unique:students,nis',
            'nama' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
        ]);

        DB::transaction(function () use ($request) {

            // Buat akun user
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Buat data siswa
            Student::create([
                'user_id' => $user->id,
                'nis' => $request->nis,
                'nama' => $request->nama,
                'class_id' => $request->class_id,
            ]);
        });

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }
}