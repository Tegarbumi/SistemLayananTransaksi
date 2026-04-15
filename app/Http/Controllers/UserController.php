<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /*
    =========================
    ROLE MANAGEMENT
    =========================
    */

    public function promote($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'role' => 1, // admin
        ]);

        return back()->with('success', 'User dijadikan Admin');
    }

    public function demote($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'role' => 0, // user biasa / kasir
        ]);

        return back()->with('success', 'Role berhasil diubah');
    }


    /*
    =========================
    EDIT AKUN SENDIRI
    =========================
    */

    public function edit()
    {
        return view('account', [
            'user' => User::findOrFail(Auth::id())
        ]);
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'name' => 'required|max:255',
            'email' => [
            'required',
            'email',
            'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
            'unique:users,email,' . $user->id
            ],
            'telepon' => 'required|max:15'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'telepon' => $request->telepon
        ]);

        return back()->with('success', 'Data berhasil diupdate');
    }


    /*
    =========================
    EDIT USER (OLEH ADMIN)
    =========================
    */

    public function editUser($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user); // untuk modal edit
    }

    public function updateUser(Request $request, $id)
{
    $user = User::findOrFail($id);

    $validator = \Validator::make($request->all(), [
        'name' => 'required|max:255',
        'email' => [
            'required',
            'email',
            'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
            'unique:users,email,' . $user->id
        ],
        'telepon' => 'required|max:15',
        'role' => 'required'
    ]);

    if ($validator->fails()) {
        return back()
            ->withErrors($validator)
            ->withInput()
            ->with('error_user_id', $id); 
    }

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'telepon' => $request->telepon,
        'role' => $request->role
    ]);

    return back()->with('success', 'User berhasil diupdate');
}


    /*
    =========================
    DELETE USER
    =========================
    */

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id == Auth::id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        if ($user->id == 1) {
            return back()->with('error', 'Admin utama tidak bisa dihapus');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus');
    }


    /*
    =========================
    CHANGE PASSWORD
    =========================
    */

    public function changePassword(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6'
        ]);

        if (Hash::check($request->oldPassword, $user->password)) {

            $user->update([
                'password' => Hash::make($request->newPassword)
            ]);

            return back()->with('success', 'Password berhasil diubah');
        } else {
            return back()->with('error', 'Password lama salah');
        }
    }
}