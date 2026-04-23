<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $authService;

    // public function __construct(AuthService $authService)
    // {
    //     $this->authService = $authService;
    // }

    public function index()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function register_process(Request $request)
    {
        try {
            // $validated = $request->validate([
            //     'name'      => 'required',
            //     'email'     => 'required|email|unique:users',
            //     'password'  => 'required|min:8'
            // ]);




            $response =  User::create([
                'name'      => $request['name'],
                'email'     => $request['email'],
                'password'  => Hash::make($request->password),
            ]);

            if (!$response) {
                return redirect()->back()
                ->with('error', 'Registrasi gagal');
            }

            return redirect()->route('login')->with('success', 'Registrasi berhasil');
        } catch (\Throwable $th) {
            Log::error("Failted register user", [
                'line'      => $th->getLine(),
                'file'      => $th->getFile(),
                'message'   => $th->getMessage()
            ]);
        }
    }
}