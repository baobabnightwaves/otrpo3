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
}