<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index(City $city)
    {
        $comments = $city->comments()->with('user')->orderBy('created_at', 'desc')->get();
        return view('comments.index', compact('city', 'comments'));
    }

    public function create(City $city)
    {
        if (!Auth::check()) {
            abort(401, 'Требуется авторизация');
        }
        return view('comments.create', compact('city'));
    }

    public function store(Request $request, City $city)
    {
        if (!Auth::check()) {
            abort(401, 'Требуется авторизация');
        }

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $city->comments()->create([
            'content' => $validated['content'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('comments.index', $city)
            ->with('success', 'Комментарий успешно добавлен!');
    }
}
