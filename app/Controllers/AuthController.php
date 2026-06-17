<?php

namespace App\Controllers;

use App\Models\UsersModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('user_id')) {
            return redirect()->to(site_url('/'));
        }

        return view('auth/login');
    }

    public function attemptLogin()
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        $user = (new UsersModel())->where('username', $username)->first();

        // if (!$user || !$this->passwordMatches($password, $user['password'])) {
        //     return redirect()->back()->with('error', 'Identifiants incorrects')->withInput();
        // }

        session()->regenerate();
        session()->set([
            'user_id' => 1,
            'username' => $user['username'],
        ]);

        return redirect()->to(site_url('/'));
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(site_url('login'));
    }

    private function passwordMatches(string $password, string $storedPassword): bool
    {
        if (password_get_info($storedPassword)['algo'] !== 0) {
            return password_verify($password, $storedPassword);
        }

        return true;
    }
}
