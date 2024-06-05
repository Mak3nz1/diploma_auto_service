<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Social;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = Auth::user();

        if ($user) {
            $socials = $user->social ?? null;
            $photo_url = $socials ? $socials->photo_url : null; // Отримання URL фото користувача
            return view('pages.profile', compact('user', 'socials'));
        } else {
            // Redirect or handle the case where the user is not authenticated
            return redirect()->route('login');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'instagram' => 'nullable|url',
        ]);
    
        $user = Auth::user();
        $socials = $user->social ?? null;
    
        if (!$socials) {
            $socials = new Social();
            $user->social()->save($socials);
        }
    
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            // Генерация уникального имени для изображения
            $photoName = time() . '_' . $photo->getClientOriginalName();
            // Сохранение изображения в папку storage/app/public/photos
            $photo->move(public_path('storage/photos'), $photoName);
            // Сохранение URL изображения в базе данных
            $socials->photo_url = asset('storage/photos/' . $photoName);
        }
    
        $socials->instagram = $request->input('instagram');
        $socials->save();
    
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
   
    public function profileForHome()
    {
        $user = Auth::user();

        if ($user) {
            $socials = $user->social; // Отримуємо соціальні дані користувача
            $photo_url = $socials ? $socials->photo_url : null; // Отримуємо URL фото користувача
            return view('home', compact('user', 'socials', 'photo_url')); // Передаємо змінні в представлення
        } else {
            // Якщо користувач не авторизований, виводимо пусту сторінку
            $user = null;
            $socials = null;
            $photo_url = null;
            return view('home', compact('user', 'socials', 'photo_url'));
        }
    }
}
