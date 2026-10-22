<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;

class ClassPageController extends Controller
{
    public function index()
    {
        $classes = ClassModel::latest()->get();

        return view('classes.index', compact('classes'));
    }
}