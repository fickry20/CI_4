<?php

namespace App\Controllers;
use App\Models\ProductModel;

class Login extends BaseController
{
    public function index()
    {
       return view('/auth/login');
    }
    
    public function auth()
    {
        $session = session();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        //Validasi username dan password statis
        if ($email === 'admin@gmail.com'  && $password =='12345'){
            // Simpan data ke session
            $sessionData = [
                'email' =>$email,
                'isLoggedIn' => true,
            ];
            $session->set($sessionData);

            // Simpan username ke cookies (kadaluwarsa 1 hari)
            setcookie('email', $email, time(), (120), "/");  //1 hari

            return redirect()->to('/home');
        } else{
            return redirect()->back()->with('error', 'Username atau password salah');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();

        // Hapus cookies
        setcookie('email', '', time() -120, "/");

        return redirect()->to('/');
    }
}