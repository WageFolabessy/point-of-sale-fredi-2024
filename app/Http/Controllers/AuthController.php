<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return redirect('/');
        }

        return back()->withErrors([
            'error' => 'Username atau Password salah',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function index()
    {
        if (Gate::allows('admin')) {
            $user = User::orderBy('created_at', 'desc')->get();

            return DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('is_admin', function ($user) {
                    if ($user->is_admin == false) {
                        return 'Biasa';
                    } else {
                        return 'Admin';
                    }
                })
                ->addColumn('aksi', function ($user) {
                    return view('components.user-tombol-aksi')->with('user', $user);
                })
                ->rawColumns(['is_admin'])
                ->make(true);
        }

        $user = Auth::user();

        return DataTables::of(collect([$user]))
            ->addIndexColumn()
            ->addColumn('is_admin', function ($user) {
                return $user->is_admin ? 'Admin' : 'Biasa';
            })
            ->addColumn('aksi', function ($user) {
                return view('components.user-tombol-aksi')->with('user', $user);
            })
            ->rawColumns(['is_admin'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'username' => 'required|unique:users,username',
            'is_admin' => 'required',
            'password' => 'required',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nama.required' => 'Nama harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah digunakan',
            'is_admin.required' => 'Peran harus diisi',
            'password.required' => 'Password harus diisi',
            'foto_profil.image' => 'Foto Profil harus berupa gambar',
            'foto_profil.mimes' => 'Foto Profil harus berupa file jpeg, png, jpg, atau gif',
            'foto_profil.max' => 'Foto Profil maksimal berukuran 2MB',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        // Upload foto profil
        $fotoProfil = 'user.png'; // default value
        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $fotoProfil = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $fotoProfil);
        }

        $user = new User;
        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->is_admin = $request->is_admin;
        $user->password = Hash::make($request->password);
        $user->foto_profil = $fotoProfil; // simpan nama file foto profil
        $user->save();

        return response()->json(['message' => 'Akun berhasil ditambahkan.']);
    }


    public function edit($id)
    {
        $data = User::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'username' => 'required|unique:users,username,' . $id,
            'is_admin' => 'required',
            'password' => 'nullable',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nama.required' => 'Nama harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah digunakan',
            'is_admin.required' => 'Peran harus diisi',
            'password.nullable' => 'Password harus diisi',
            'foto_profil.image' => 'Foto Profil harus berupa gambar',
            'foto_profil.mimes' => 'Foto Profil harus berupa file jpeg, png, jpg, atau gif',
            'foto_profil.max' => 'Foto Profil maksimal berukuran 2MB',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user = User::find($id);
        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->is_admin = $request->is_admin;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Upload foto profil jika ada
        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $fotoProfil = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $fotoProfil);

            // Delete old foto profil if exists and not default 'user.png'
            if ($user->foto_profil && $user->foto_profil !== 'user.png') {
                $oldFile = public_path('images') . '/' . $user->foto_profil;
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            $user->foto_profil = $fotoProfil;
        }

        $user->save();
        return response()->json(['message' => 'Profil User berhasil diperbaharui.']);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json([
            'message' => 'Akun berhasil dihapus'
        ]);
    }
}
