<?php

namespace App\Controllers;

class AboutController extends BaseController
{
    public function index()
    {
        // Langsung tampilkan view, tidak perlu ambil data dari model
        return view('about/index');
    }
}