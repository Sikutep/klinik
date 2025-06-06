<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search   = $request->query('search');
        $perPage  = $request->query('per_page', 10);


        $query = Users::with('role:id,nama')
            ->select('id', 'avatar', 'nama', 'no_induk_karyawan', 'email', 'is_active', 'role_id', 'created_at')
            ->orderBy('created_at', 'desc');


        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('no_induk_karyawan', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate($perPage);

        return response()->json($data);
        // return view('users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Logic to show the form for creating a new user
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (session('user_role') == 1) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }


        $validate = $request->validate([
            'nama' => 'required|string|max:255',
            'no_induk_karyawan' => 'required|string|max:255|unique:users,no_induk_karyawan',
            'no_hp' => 'required|string|max:15|unique:users,no_hp',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8|same:password',
            'alamat' => 'nullable|string|max:255',
            'kota' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'negara' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'boolean',

        ]);

        $user = Users::create([
            'nama' => $validate['nama'],
            'no_induk_karyawan' => $validate['no_induk_karyawan'],
            'no_hp' => $validate['no_hp'],
            'email' => $validate['email'],
            'password' => bcrypt($validate['password']),
            'alamat' => $validate['alamat'],
            'kota' => $validate['kota'],
            'provinsi' => $validate['provinsi'],
            'negara' => $validate['negara'],
            'kode_pos' => $validate['kode_pos'],
            'role_id' => $validate['role_id'],
            'is_active' => $validate['is_active'] ?? true,
        ]);

        if ($request->hasFile('avatar')) {
            $file     = $request->file('avatar');
            $filename = time() . '_' . $user->no_induk_karyawan . '_' . $file->getClientOriginalName();


            $file->move(public_path('img/img_profile'), $filename);

            $user->avatar = "img/img_profile/{$filename}";
            $user->save();
        } else {
            $user->avatar = 'img/img_profile/default.png'; // Set a default avatar if none is uploaded
            $user->save();
        }


        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = Users::with('role:id,nama')->findOrFail($id);

        return response()->json($user);
        // return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Logic to show the form for editing a user
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $user = Users::findOrFail($id);

        $validate = $request->validate([
            'nama' => 'required|string|max:255',
            'no_induk_karyawan' => 'required|string|max:255|unique:users,no_induk_karyawan,' . $user->id,
            'no_hp' => 'required|string|max:15|unique:users,no_hp,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'alamat' => 'nullable|string|max:255',
            'kota' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'negara' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'boolean',
        ]);

        $user->update([
            'nama' => $validate['nama'],
            'no_induk_karyawan' => $validate['no_induk_karyawan'],
            'no_hp' => $validate['no_hp'],
            'email' => $validate['email'],
            'alamat' => $validate['alamat'],
            'kota' => $validate['kota'],
            'provinsi' => $validate['provinsi'],
            'negara' => $validate['negara'],
            'kode_pos' => $validate['kode_pos'],
            'role_id' => $validate['role_id'],
            'is_active' => $validate['is_active'] ?? true,
        ]);

        if ($request->hasFile('avatar')) {
            $file     = $request->file('avatar');
            $filename = time() . '_' . $user->no_induk_karyawan . '_' . $file->getClientOriginalName();


            if ($user->avatar && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }

            $file->move(public_path('img/img_profile'), $filename);
            $user->avatar = "img/img_profile/{$filename}";
            $user->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (request()->user()->role_id == 1) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $validate = request()->validate([
            'id' => 'required|exists:users,id',
        ]);


        $id = $validate['id'];
        $user = Users::findOrFail($id);


        if ($user->avatar && file_exists(public_path($user->avatar))) {
            unlink(public_path($user->avatar));
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully',
        ], 200);
    }
}
