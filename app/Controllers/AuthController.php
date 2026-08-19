<?php

class AuthController {
    public function showLogin(): void {
        if (Auth::check()) redirect('/');
        view('auth/login', ['title' => 'Masuk']);
    }

    public function login(): void {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        set_old(['email' => $email]);

        $user = User::findByEmail($email);
        if (!$user || !password_verify($password, $user['password_hash'])) {
            flash('error', 'Email atau password tidak valid.');
            redirect('/login');
        }
        clear_old();
        Auth::login($user);
        flash('success', 'Selamat kembali, ' . $user['name'] . '!');
        redirect($user['role'] === 'admin' ? '/admin' : '/dashboard');
    }

    public function showRegister(): void {
        if (Auth::check()) redirect('/');
        view('auth/register', ['title' => 'Buat Akun']);
    }

    public function register(): void {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        set_old(['name' => $name, 'email' => $email]);

        $errors = [];
        if ($name === '') $errors[] = 'Nama diperlukan.';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email yang valid diperlukan.';
        if (strlen($password) < 6) $errors[] = 'Password harus minimal 6 karakter.';
        if (!$errors && User::findByEmail($email)) $errors[] = 'Akun dengan email ini sudah ada.';

        if ($errors) {
            flash('error', implode(' ', $errors));
            redirect('/register');
        }

        $id = User::create($name, $email, $password, 'buyer');
        clear_old();
        Auth::login(User::find($id));
        flash('success', 'Akun dibuat. Selamat datang di DevMarket!');
        redirect('/dashboard');
    }

    public function logout(): void {
        Auth::logout();
        flash('success', 'Anda telah keluar.');
        redirect('/');
    }
}
