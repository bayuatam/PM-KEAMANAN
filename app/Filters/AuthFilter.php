<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Jika pengguna belum login, paksa kembali ke halaman login
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Cek otorisasi berdasarkan peran (role)
        $uri = service('uri');
        $role = $session->get('role');

        // Jika mencoba akses halaman admin tapi bukan penjual
        if ($uri->getSegment(1) === 'admin' && $role !== 'penjual') {
            return redirect()->to('/')->with('error', 'Anda tidak memiliki hak akses.');
        }

        // Jika mencoba akses halaman logistik tapi bukan petugas logistik
        if ($uri->getSegment(1) === 'logistics' && $role !== 'logistik') {
            return redirect()->to('/')->with('error', 'Anda tidak memiliki hak akses.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi setelah request
    }
}