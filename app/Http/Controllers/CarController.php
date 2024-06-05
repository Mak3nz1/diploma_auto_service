<?php

namespace App\Http\Controllers;

use App\Models\Car; 
use Illuminate\Http\Request;

class CarController extends Controller
{

    public function index()
    {
        $cars = Car::where('user_id', auth()->id())->get(); // Retrieve cars for the authenticated user
        $activeCar = Car::where('is_active', true)->where('user_id', auth()->id())->first();
        return view('сars\index', compact('cars', 'activeCar'));
    }
    public function showOrderForm()
    {
        $cars = Car::where('user_id', auth()->id())->get();
        $activeCar = Car::where('is_active', true)->where('user_id', auth()->id())->first();
        return view('order.form', compact('activeCar'));
    }
    public function create()
    {
        return view('сars\create');
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'integer'],
            'company' => ['required', 'string'],
            'model' => ['required', 'string'],
            'year' => ['required', 'integer'],
            'vin_code' => ['required', 'string', 'size:17', 'unique:cars,vin_code,NULL,id,user_id,' . $request->user_id], // Перевірте на унікальність в таблиці cars для обраного користувача
        ]);
    
        $car = Car::create([
            'user_id' => $request->user_id,
            'company' => $request->company,
            'model' => $request->model,
            'year' => $request->year,
            'vin_code' => $request->vin_code,
        ]);
    
        return redirect()->route('cars.index')->with('success', 'Car created successfully.');
    }

    public function edit(Car $car) // Змінено назву моделі на "Car"
    {
        return view('сars\edit', compact('car'));
    }

    public function update(Request $request, Car $car) // Змінено назву моделі на "Car"
    {
        $request->validate([
            'user_id' => 'required|integer',
            'company' => 'required',
            'model' => 'required',
            'year' => 'required|integer',
            'vin_code' => 'required',
        ]);

        $car->update($request->all());

        return redirect()->route('cars.index')->with('success', 'Car updated successfully.');
    }

    public function destroy(Car $car) // Змінено назву моделі на "Car"
    {
        $car->delete();

        return redirect()->route('cars.index')->with('success', 'Car deleted.');
    }
    public function setActive(Request $request, Car $car)
{
    // Зняти активність з усіх інших машин для конкретного юзера
    Car::where('user_id', auth()->id())->where('car_id', '<>', $car->car_id)->update(['is_active' => false]);

    // Встановити активність для обраної машини для конкретного юзера
    $car->update(['is_active' => true]);

    return redirect()->route('cars.index')->with('success', 'Car set as active.');
}
    
}
