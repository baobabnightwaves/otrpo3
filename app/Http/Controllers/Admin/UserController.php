<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount('cities')->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('cities');
        $stats = [
            'total_cities' => $user->cities()->count(),
            'last_login' => $user->last_login_at ? $user->last_login_at->format('d.m.Y H:i') : 'Никогда',
            'created_at' => $user->created_at->format('d.m.Y H:i'),
        ];
        
        return view('admin.users.show', compact('user', 'stats'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'is_admin' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Пользователь успешно обновлен!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Вы не можете удалить свой собственный аккаунт!');
        }

        $user->cities()->delete();
        
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Пользователь и его города успешно удалены!');
    }

    public function toggleAdmin(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Вы не можете изменить свой собственный статус администратора!');
        }

        $user->update(['is_admin' => !$user->is_admin]);

        $status = $user->is_admin ? 'назначен администратором' : 'лишен прав администратора';
        return back()->with('success', "Пользователь {$user->name} {$status}!");
    }

    public function userCities(User $user)
    {
        $cities = $user->cities()->latest()->paginate(10);
        return view('cities.index', compact('cities'));
    }
}