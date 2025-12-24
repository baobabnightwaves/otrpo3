<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact(['users']));
    }

    public function toggle_admin(Request $request, User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->back()
                ->with('error', 'Вы не можете изменить свои собственные права');
        }
        
        $user->is_admin = !$user->is_admin;
        $user->save();
        
        $action = $user->is_admin ? 'назначен администратором' : 'лишен прав администратора';
        
        return redirect()->back()
            ->with('success', "Пользователь {$user->name} успешно {$action}");
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->back()
                ->with('error', 'Вы не можете удалить сами себя');
        }
        
        $userName = $user->name;        
        $user->delete();
        
        return redirect()->route('users.index')
            ->with('success', "Пользователь {$userName} успешно удален");
    }

    public function befriend(User $user)
    {
        if (!Auth::check()) {
            abort(401, 'Требуется авторизация');
        }

        $currentUser = Auth::user();
        
        if ($currentUser->id === $user->id) {
            return redirect()->back()
                ->with('error', 'Вы не можете добавить себя в друзья');
        }

        if ($currentUser->addFriend($user)) {
            return redirect()->back()
                ->with('success', "Пользователь {$user->name} добавлен в друзья");
        }

        return redirect()->back()
            ->with('error', 'Этот пользователь уже в вашем списке друзей');
    }

    public function unfriend(User $user)
    {
        if (!Auth::check()) {
            abort(401, 'Требуется авторизация');
        }

        $currentUser = Auth::user();
        
        if ($currentUser->removeFriend($user)) {
            return redirect()->back()
                ->with('success', "Пользователь {$user->name} удален из друзей");
        }

        return redirect()->back()
            ->with('error', 'Ошибка при удалении из друзей');
    }

    public function feed(User $user)
    {
        $cities = collect();
        
        foreach ($user->friends as $friend) {
            $friendCities = $friend->cities;
            $cities = $cities->merge($friendCities);
        }
        
        $cities = $cities->sortByDesc('created_at');
        
        return view('cities.index', compact('cities'));
    }
}