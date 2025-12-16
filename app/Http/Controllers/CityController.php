<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Gate;

class CityController extends Controller
{
    public function index(User $User = null)
    {
        if (is_null($User))
        {
            $cities = City::withTrashed()->get();
        }
        else
        {
            $cities = $User->cities;
        }

        return view('cities.index', compact(['cities']));
    }

    public function restore(Request $request, int $id)
    {
        $city = City::withTrashed()->findOrFail($id);
        
        if (!Auth::check()) {
            abort(401, 'Требуется авторизация');
        }
        
        if (!Gate::allows('modify-city', $city)) {
            abort(403, 'У вас нет прав для восстановления этого города');
        }
        
        if (!$city->trashed()) {
            return redirect()->back()
                ->with('error', 'Город уже восстановлен');
        }
        
        try {
            $city->restore();
            return redirect()->route('cities.index', $city)
                ->with('success', 'Город "' . $city->name . '" успешно восстановлен');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при восстановлении города: ' . $e->getMessage());
        }
    }

    public function purge(Request $request, int $id)
    {
        $city = City::withTrashed()->findOrFail($id);
        
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(401, 'Требуется авторизация');
        }
        
        if (!Auth::user()->is_admin) {
            abort(403, 'Только администратор может полностью удалять города');
        }

        try {
            $city->forceDelete();
            return redirect()->route('cities.index');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при удалении города: ' . $e->getMessage());
        }
    }

    public function create()
    {
        if (!Auth::check()) {
            abort(401, 'Требуется авторизация');
        }
        return view('cities.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            abort(401, 'Требуется авторизация');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'coat_of_arms_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'card_text' => 'required|string|max:500',
            'modal_text' => 'required|string',
            'city_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'wiki_url' => 'required|url|max:500',
            'interesting_fact' => 'required|string|max:1000',
        ]);

        if ($request->hasFile('coat_of_arms_image')) {
            $image = $request->file('coat_of_arms_image');
            $filename = 'coat_of_arms_' . time() . '.' . $image->getClientOriginalExtension();            
            $imagePath = storage_path('app/public/' . $filename);
            
            Image::make($image)
                ->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($imagePath);
            
            $validated['coat_of_arms_image'] = $filename;
        }

        if ($request->hasFile('city_image')) {
            $image = $request->file('city_image');
            $filename = 'city_' . time() . '.' . $image->getClientOriginalExtension();            
            $imagePath = storage_path('app/public/' . $filename);
            
            Image::make($image)
                ->resize(800, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($imagePath);
            
            $validated['city_image'] = $filename;
        }

        City::create($validated);
        
        return redirect()->route('cities.index')
            ->with('success', 'Город успешно создан!');
    }

    public function show(City $city)
    {
        $cities = City::all();        
        return view('cities.show', compact('city', 'cities'));
    }

    public function edit(City $city)
    {
        if (!Auth::check()) {
            abort(401, 'Требуется авторизация');
        }

        if (!Gate::allows('modify-city', $city)) {
            abort(403, 'У вас нет прав для редактирования этого города');
        }

        return view('cities.edit', compact('city'));
    }

    public function update(Request $request, City $city)
    {
        if (!Auth::check()) {
            abort(401, 'Требуется авторизация');
        }
        
        if (!Gate::allows('modify-city', $city)) {
            abort(403, 'У вас нет прав для редактирования этого города');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'coat_of_arms_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'card_text' => 'required|string|max:500',
            'modal_text' => 'required|string',
            'city_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'wiki_url' => 'required|url|max:500',
            'interesting_fact' => 'required|string|max:1000',
        ]);

        if ($request->hasFile('coat_of_arms_image')) {
            if ($city->coat_of_arms_image && Storage::disk('public')->exists($city->coat_of_arms_image)) {
                Storage::disk('public')->delete($city->coat_of_arms_image);
            }

            $image = $request->file('coat_of_arms_image');
            $filename = 'coat_of_arms_' . time() . '.' . $image->getClientOriginalExtension();            
            $imagePath = storage_path('app/public/' . $filename);
            
            Image::make($image)
                ->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($imagePath);
            
            $validated['coat_of_arms_image'] = $filename;
        } else {
            $validated['coat_of_arms_image'] = $city->coat_of_arms_image;
        }

        if ($request->hasFile('city_image')) {
            if ($city->city_image && Storage::disk('public')->exists($city->city_image)) {
                Storage::disk('public')->delete($city->city_image);
            }

            $image = $request->file('city_image');
            $filename = 'city_' . time() . '.' . $image->getClientOriginalExtension();
            
            $imagePath = storage_path('app/public/' . $filename);
            
            Image::make($image)
                ->resize(800, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($imagePath);
            
            $validated['city_image'] = $filename;
        } else {
            $validated['city_image'] = $city->city_image;
        }

        $city->update($validated);

        return redirect()->route('cities.index')
            ->with('success', 'Город успешно обновлен!');
    }

    public function destroy(City $city)
    {
        if (!Auth::check()) {
            abort(401, 'Требуется авторизация');
        }
        
        if (!Gate::allows('modify-city', $city)) {
            abort(403, 'У вас нет прав для удаления этого города');
        }

        $city->delete();
        return redirect()->route('cities.index')
            ->with('success', 'Город успешно удален!');
    }
}