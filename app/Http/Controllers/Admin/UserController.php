<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
class UserController extends Controller
{
    public function index()
    {
        $users = DB::table('users')->orderBy('user_id', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:user,admin',
            'no_hp' => 'nullable|string|max:20',
            'school_name' => 'nullable|string|max:255',
        ]);

        DB::table('users')->insert([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'no_hp' => $request->no_hp,
            'school_name' => $request->school_name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit($user_id)
    {
        $user = DB::table('users')->where('user_id', $user_id)->first();
        if (!$user) abort(404);
        $users = DB::table('users')->orderBy('user_id', 'desc')->get();
        return view('admin.users.index', compact('user', 'users'));
    }

    public function update(Request $request, $user_id)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user_id, 'user_id')
            ],
            'role' => 'required|in:user,admin',
            'no_hp' => 'nullable|string|max:20',
            'school_name' => 'nullable|string|max:255',
        ]);


        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'role' => $request->role,
            'no_hp' => $request->no_hp,
            'school_name' => $request->school_name,
            'updated_at' => now(),
        ];

        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        DB::table('users')->where('user_id', $user_id)->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy($user_id)
    {
        if ($user_id == auth()->id()) {
            return redirect()->back()->withErrors('Anda tidak bisa menghapus akun sendiri.');
        }
        DB::table('users')->where('user_id', $user_id)->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
