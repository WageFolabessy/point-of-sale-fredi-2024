<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $user = User::orderBy('created_at', 'desc')->get();

        return DataTables::of($user)
            ->addIndexColumn()
            ->addColumn('is_admin', function ($user){
                if($user->is_admin == false){
                    return 'Biasa';
                }
                else{
                    return 'Admin';
                }
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
            'username' => 'required|unique:users,username,',
            'is_admin' => 'required',
            'password' => 'required',
        ], [
            'nama.required' => 'Nama harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah digunakan',
            'is_admin.required' => 'Peran harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user = new User;
        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->is_admin = $request->is_admin;
        $user->password = Hash::make($request->password);
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
        ], [
            'nama.required' => 'Nama harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah digunakan',
            'is_admin.required' => 'Peran harus diisi',
            'password.nullable' => 'Password harus diisi',
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
