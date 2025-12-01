<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();
        return view('cities.index', compact('cities'));
    }

    public function create()
    {
        return view('cities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'coat_of_arms_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120', // 5MB
            'card_text' => 'required|string|max:500',
            'modal_id' => 'required|string|unique:cities|max:100',
            'modal_title' => 'required|string|max:255',
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
        return view('cities.show', compact('city'));
    }

    public function edit(City $city)
    {
        return view('cities.edit', compact('city'));
    }

    public function update(Request $request, City $city)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'coat_of_arms_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'card_text' => 'required|string|max:500',
            'modal_id' => 'required|string|max:100|unique:cities,modal_id,' . $city->id,
            'modal_title' => 'required|string|max:255',
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
        }

        $city->update($validated);

        return redirect()->route('cities.index')
            ->with('success', 'Город обновлен');
    }

    public function destroy(City $city)
    {
        if ($city->coat_of_arms_image && Storage::disk('public')->exists($city->coat_of_arms_image)) {
            Storage::disk('public')->delete($city->coat_of_arms_image);
        }
        if ($city->city_image && Storage::disk('public')->exists($city->city_image)) {
            Storage::disk('public')->delete($city->city_image);
        }

        $city->delete();

        return redirect()->route('cities.index')
            ->with('success', 'Город удален');
    }
}