<?php

namespace App\Controllers;

use App\Models\UserModel;

class RegisterController extends BaseController
{
    /**
     * Menampilkan form registrasi untuk penjual/admin baru.
     */
    public function showSellerRegisterForm()
    {
        // Menggunakan layout mandiri untuk registrasi
        return view('auth/register/seller');
    }

    /**
     * Memproses data dari form registrasi.
     */
    public function processRegister()
    {
        $userModel = new UserModel();

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'kelas'     => $this->request->getPost('kelas'),
            'prodi'     => $this->request->getPost('prodi'),
            'email'     => $this->request->getPost('email'),
            'password'  => $this->request->getPost('password'),
            'role'      => 'admin' // Langsung set role sebagai admin
        ];
        
        // Ganti save() dengan insert() untuk memastikan data baru selalu dibuat
        if ($userModel->insert($data)) {
            // Jika berhasil, kembali ke halaman utama dengan pesan sukses
            return redirect()->to('/')->with('success', 'Registrasi berhasil! Silakan login untuk melanjutkan.');
        } else {
            // Jika gagal, kembali ke form dengan pesan error
            return redirect()->back()->withInput()->with('errors', $userModel->getErrors());
        }
    }
}