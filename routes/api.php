<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\City;
use App\Models\Comment;
use App\Http\Resources\CityResource;
use App\Http\Resources\CommentResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    // City API routes (main entity)
    Route::get('cities', function() {
        return CityResource::collection(City::with('owner')->get());
    });

    Route::get('cities/{id}', function($id) {
        $city = City::with('owner')->findOrFail($id);
        return new CityResource($city);
    });

    Route::post('cities', function(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'card_text' => 'nullable|string|max:500',
            'modal_title' => 'nullable|string|max:255',
            'modal_text' => 'nullable|string',
            'wiki_url' => 'nullable|url',
            'interesting_fact' => 'nullable|string',
        ]);

        $city = City::create($request->all());
        return new CityResource($city);
    });

    Route::put('cities/{id}', function(Request $request, $id) {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'card_text' => 'nullable|string|max:500',
            'modal_title' => 'nullable|string|max:255',
            'modal_text' => 'nullable|string',
            'wiki_url' => 'nullable|url',
            'interesting_fact' => 'nullable|string',
        ]);

        $city = City::findOrFail($id);
        $city->update($request->all());
        return new CityResource($city);
    });

    Route::delete('cities/{id}', function($id) {
        $city = City::findOrFail($id);
        $city->delete();
        return response()->json(['message' => 'City deleted successfully'], 200);
    });

    // Comment API routes (secondary entity)
    Route::get('comments', function() {
        return CommentResource::collection(Comment::with(['city', 'user'])->get());
    });

    Route::get('comments/{id}', function($id) {
        $comment = Comment::with(['city', 'user'])->findOrFail($id);
        return new CommentResource($comment);
    });

    Route::post('comments', function(Request $request) {
        $request->validate([
            'content' => 'required|string',
            'city_id' => 'required|exists:cities,id',
        ]);

        $comment = Comment::create([
            'content' => $request->content,
            'city_id' => $request->city_id,
            'user_id' => auth()->id(),
        ]);

        return new CommentResource($comment->load(['city', 'user']));
    });

    Route::put('comments/{id}', function(Request $request, $id) {
        $request->validate([
            'content' => 'sometimes|required|string',
        ]);

        $comment = Comment::findOrFail($id);
        
        // Only allow users to update their own comments
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->update($request->only('content'));
        return new CommentResource($comment->load(['city', 'user']));
    });

    Route::delete('comments/{id}', function($id) {
        $comment = Comment::findOrFail($id);
        
        // Only allow users to delete their own comments
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();
        return response()->json(['message' => 'Comment deleted successfully'], 200);
    });
});
