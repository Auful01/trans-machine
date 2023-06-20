<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Traits\Response;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use Response;

    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->error('Email atau password anda salah');
            }

            User::where('email', $request->email)->update([
                'remember_token' => $token,
                'status' => 'aktif'
            ]);

            $return = [
                'token' => $token,
                'user' => User::with('role:name,id')->where('email', $request->email)->first()
            ];


            return $this->success($return, 'Login success');
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    public function register(AuthRequest $request)
    {
        try {
            DB::beginTransaction();
            if (isset($request->validator) && $request->validator->fails()) {
                return $this->error($request->validator->errors());
            }

            $user = User::create([
                'name' => $request->name,
                'role_id' => $request->role_id ?? 3,
                'identity_num' => $request->identity_num ?? null,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            if ($request->role_id == 2) {
                Dosen::create([
                    'user_id' => $user->id
                ]);
            } else if ($request->role_id == 3 || !isset($request->role_id)) {

                if (Mahasiswa::where('nim', $request->identity_num)->first()) {
                    return $this->error('Mahasiswa Belum Terdaftar, silahkan hubungi admin untuk melakukan pendaftaran');
                }
                Mahasiswa::create([
                    'user_id' => $user->id
                ]);
            }


            $token = JWTAuth::fromUser($user);

            $return = [
                'token' => $token,
                'user' => $user
            ];

            DB::commit();

            return $this->success($return, 'Register success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error($th->getMessage());
        }
    }

    public function profile()
    {
        $data = Auth::user();
        // $retData = null;
        switch ($data->role_id) {
            case '2':
                # code...
                $retData = Dosen::with('user')->where('user_id', $data->id)->first();
                break;

            case '3':
                $retData = Mahasiswa::with('user', 'kelas')->where('user_id', $data->id)->first();
                # code...
                // dd($retData);
                break;
            default:
                # code...
                break;
        }
        // dd($retData);
        $data["detail"] = $retData;
        return $this->success($data);
    }


    public function logout(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->update([
            'remember_token' => null,
            'status' => 'tidak aktif'
        ]);
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function logoutWeb()
    {
        $user = User::find(Auth::user()->id)->update([
            'remember_token' => null,
            'status' => 'tidak aktif'
        ]);

        if (Cookie::get('admin_cookie')) {
            return redirect('/login')->withoutCookie('admin_cookie');
        } else if (Cookie::get('dosen_cookie')) {
            return redirect('/login')->withoutCookie('dosen_cookie');
        } else if (Cookie::get('mahasiswa_cookie')) {
            return redirect('/login')->withoutCookie('mahasiswa_cookie');
        }
    }

    public function routeCheck(Request $request)
    {

        if ($request->cookie('admin_cookie')) {
            return redirect('/admin');
        } else if ($request->cookie('dosen_cookie')) {
            return redirect('/admin');
        } else if ($request->cookie('mahasiswa_cookie')) {
            return redirect('/mahasiswa');
        } else {
            return  view('auth.login');
        }
    }
}
