<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Добавляем этот импорт
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CityController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            if ($user->isAdmin()) {
                $cities = City::with('user')->latest()->get();
            } else {
                $cities = $user->cities()->latest()->get();
            }
        } else {
            $cities = City::latest()->get();
        }

        return view('cities.index', compact('cities'));
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Для создания города необходимо авторизоваться.');
        }
        
        return view('cities.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Для создания города необходимо авторизоваться.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'coat_of_arms_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'card_text' => 'required|string|max:500',
            'modal_title' => 'required|string|max:255',
            'modal_text' => 'required|string',
            'city_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'wiki_url' => 'required|url|max:500',
            'interesting_fact' => 'required|string|max:1000',
        ]);

        $validated['user_id'] = Auth::id();

        if ($request->hasFile('coat_of_arms_image')) {
            $image = $request->file('coat_of_arms_image');
            $filename = 'coat_of_arms_' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('storage/' . $filename);
            if (!file_exists(public_path('storage/'))) {
                mkdir(public_path('storage/'), 0755, true);
            }
            
            Image::make($image->getRealPath())
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
            $imagePath = public_path('storage/' . $filename);
            
            Image::make($image->getRealPath())
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
        return view('cities.show', compact('city'));
    }

    public function edit(City $city)
    {
        if (!$this->authorizeCityAccess($city)) {
            return redirect()->route('cities.index')
                ->with('error', 'У вас нет прав для редактирования этого города.');
        }
        
        return view('cities.edit', compact('city'));
    }

    public function update(Request $request, City $city)
    {
        if (!$this->authorizeCityAccess($city)) {
            return redirect()->route('cities.index')
                ->with('error', 'У вас нет прав для редактирования этого города.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'coat_of_arms_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'card_text' => 'required|string|max:500',
            'modal_title' => 'required|string|max:255',
            'modal_text' => 'required|string',
            'city_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'wiki_url' => 'required|url|max:500',
            'interesting_fact' => 'required|string|max:1000',
        ]);

        if ($request->hasFile('coat_of_arms_image')) {
            if ($city->coat_of_arms_image && file_exists(public_path('storage/' . $city->coat_of_arms_image))) {
                unlink(public_path('storage/' . $city->coat_of_arms_image));
            }

            $image = $request->file('coat_of_arms_image');
            $filename = 'coat_of_arms_' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('storage/' . $filename);
            
            Image::make($image->getRealPath())
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
            if ($city->city_image && file_exists(public_path('storage/' . $city->city_image))) {
                unlink(public_path('storage/' . $city->city_image));
            }

            $image = $request->file('city_image');
            $filename = 'city_' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('storage/' . $filename);
            
            Image::make($image->getRealPath())
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
            ->with('success', 'Город обновлен');
    }

    public function destroy(City $city)
    {
        if (!$this->authorizeCityAccess($city)) {
            return redirect()->route('cities.index')
                ->with('error', 'У вас нет прав для удаления этого города.');
        }
        
        $city->delete();

        return redirect()->route('cities.index')
            ->with('success', 'Город удален');
    }

    private function authorizeCityAccess(City $city): bool
    {
        $user = Auth::user();
        
        if (!$user) {
            return false;
        }
        
        if ($user->isAdmin()) {
            return true;
        }
        
        return $city->user_id === $user->id;
    }

    public function indexByUser(User $user = null)
    {
        if (is_null($user)) {
            $cities = City::withTrashed()->get();
        } else {
            $cities = $user->cities;
        }
        
        return view('cities.index', compact('cities'));
    }
}