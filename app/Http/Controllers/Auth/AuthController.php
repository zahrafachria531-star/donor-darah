<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller; // Pastikan ini ada
use App\Models\User;                 // Pastikan ini ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman form login
     */
    public function showLogin()
    {
        return view('auth.login');
    }
/**
 * Menampilkan halaman form registrasi
 */
public function showRegister()
{
    return view('auth.register');
}
    /**
     * Memproses request login pengguna
     */
    public function login(Request $request)
    {
        // 1. Validasi input form
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // 2. Cek apakah user mencentang 'Remember Me'
        $remember = $request->has('remember');

        // 3. Proses autentikasi
        if (Auth::attempt($credentials, $remember)) {
            // Regenerasi session untuk mencegah serangan session fixation
            $request->session()->regenerate();

            // Arahkan ke dashboard jika berhasil masuk
            return redirect()->intended('/dashboard')->with('success', 'Selamat datang kembali!');
        }

        // 4. Jika gagal, kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email'); // Tetap simpan input email agar user tidak perlu mengetik ulang
    }

    /**
     * Memproses pendaftaran pengguna baru (Pendonor)
     * (Berguna jika nanti Anda membuat halaman/form registrasi)
     */
    public function register(Request $request)
    {
        // 1. Validasi input pendaftaran
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // form view harus punya field 'password_confirmation'
            'phone_number' => ['nullable', 'string', 'max:15'],
            'blood_type' => ['nullable', 'in:A,B,AB,O'],
            'rhesus' => ['nullable', 'in:+,-'],
        ]);

        // 2. Simpan user baru ke database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password wajib di-hash (enkripsi)
            'phone_number' => $request->phone_number,
            'blood_type' => $request->blood_type,
            'rhesus' => $request->rhesus ?? '+', // Default rhesus positif jika tidak diisi
        ]);

        // 3. Otomatis login user setelah berhasil mendaftar
        Auth::login($user);

        // 4. Arahkan ke dashboard
        return redirect('/dashboard')->with('success', 'Akun berhasil dibuat. Mari mulai berbagi harapan!');
    }

    /**
     * Memproses logout pengguna
     */
    public function logout(Request $request)
    {
        // 1. Lakukan proses logout
        Auth::logout();

        // 2. Hapus semua data di session saat ini
        $request->session()->invalidate();

        // 3. Buat ulang token CSRF untuk keamanan
        $request->session()->regenerateToken();

        // 4. Arahkan kembali ke halaman landing page
        return redirect('/')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}