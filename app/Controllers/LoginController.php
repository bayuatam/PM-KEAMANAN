<?php

namespace App\Controllers;

use App\Models\UserModel;

class LoginController extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }

    public function processLogin()
    {
        $userModel = new UserModel();
        $session = session();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $email)->first();

        // Cek jika user ada dan password cocok
        if ($user && password_verify($password, $user['password'])) {
            
            // Siapkan data untuk session
            $sessionData = [
                'user_id'   => $user['id'],
                'full_name' => $user['full_name'],
                'email'     => $user['email'],
                'role'      => $user['role'], // Mengambil peran dari database
                'isLoggedIn'=> TRUE
            ];
            $session->set($sessionData);

            // Logika pengalihan berdasarkan peran
            if ($user['role'] == 'penjual') {
                return redirect()->to('/admin');
            } elseif ($user['role'] == 'logistik') {
                return redirect()->to('/logistics');
            } else {
                // Untuk peran 'pembeli' atau lainnya, arahkan ke halaman utama
                return redirect()->to('/'); 
            }
        }

        // Jika user tidak ditemukan atau password salah
        return redirect()->to('/login')->with('error', 'Email atau Password salah.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda berhasil keluar.');
    }
}