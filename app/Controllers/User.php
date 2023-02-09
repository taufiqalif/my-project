<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
  public function index()
  {
    return view('auth/login');
  }

  public function register()
  {
    return view('auth/register');
  }

  public function proses_login()
  {
    $users = new UserModel();
    $email = $this->request->getVar('email');
    $password = $this->request->getVar('password');
    $dataUser = $users->where([
      'email' => $email,
      'password' => $password
    ])->first();
    if ($dataUser) {
      if (password_verify($password, $dataUser->$password)) {
        session()->set([
          'email' => $dataUser->email,
          'username' => $dataUser->username,
          'logged_in' => TRUE
        ]);
        return redirect()->to(base_url('home'));
      } else {
        session()->setFlashdata('error', 'Email & Password Salah');
        return redirect()->back();
      }
    } else {
      session()->setFlashdata('error', 'Email & Password Salah');
      return redirect()->back();
    }
  }

  public function proses()
  {
    if (!$this->validate([
      'username' => [
        'rules' => 'required|min_length[4]|max_length[20]|is_unique[users.username]',
        'errors' => [
          'required' => '{field} Harus diisi',
          'min_length' => '{field} Minimal 4 Karakter',
          'max_length' => '{field} Maksimal 20 Karakter',
          'is_unique' => 'Username sudah digunakan sebelumnya'
        ]
      ],
      'email' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Harus diisi'
        ]
      ],
      'password' => [
        'rules' => 'required|min_length[4]|max_length[50]',
        'errors' => [
          'required' => '{field} Harus diisi',
          'min_length' => '{field} Minimal 4 Karakter',
          'max_length' => '{field} Maksimal 50 Karakter',
        ]
      ],
      'password2' => [
        'rules' => 'matches[password]',
        'errors' => [
          'matches' => 'Konfirmasi Password tidak sesuai',
        ]
      ],

    ])) {
      session()->setFlashdata('error', $this->validator->listErrors());
      return redirect()->back()->withInput();
    }
    $users = new UserModel();
    $users->insert([
      'username' => $this->request->getVar('username'),
      'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
      'email' => $this->request->getVar('email')
    ]);
    return redirect()->to('/');
  }

  function logout()
  {
    session()->destroy();
    return redirect()->to('/');
  }
}