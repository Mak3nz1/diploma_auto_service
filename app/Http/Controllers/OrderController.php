<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Car;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;


class OrderController extends Controller
{   
    
    public function saveServiceId(Request $request)
    { 
        $serviceId = $request->input('serviceId');

        // Store the serviceId in the session or controller property
        session(['activeServiceId' => $serviceId]);
    
        try {
            $serviceId = $request->input('serviceId');
            // Add debugging statements
            \Log::info('Received serviceId: ' . $serviceId);
            // Your existing code to save the serviceId
            return response()->json(['message' => 'ServiceId saved successfully']);
        } catch (\Exception $e) {
            // Log the exception
            \Log::error('Error saving serviceId: ' . $e->getMessage());
    
            return response()->json(['error' => 'Failed to save serviceId'], 500);
        }
    }   
    public function saveCarDateTime(Request $request)
    { try {
        // Log the received request data
        \Log::info('Received Request Data:', $request->all());

        // Validate the request data
        $validatedData = $request->validate([
            'car_date' => 'required|date',
            'car_time' => 'required|date_format:H:i',
        ]);

        // Log the validated data
        \Log::info('Validated Data:', $validatedData);

        // Save car_date and car_time in the session
        session([
            'car_date' => $validatedData['car_date'],
            'car_time' => $validatedData['car_time'],
        ]);

        return response()->json(['message' => 'Car date and time saved successfully']);
    } catch (\Exception $e) {
        // Log the exception
        \Log::error('Error saving car_date and car_time: ' . $e->getMessage());

        return response()->json(['error' => 'Failed to save car date and time'], 500);
    }
    }
    public function ordercreation(Request $request)
    {
        try {
            // Retrieve car_date and car_time from the session
            $carDate = session('car_date');
            $carTime = session('car_time');
    
            // Validate the working hours (9:00 - 20:00) and working day
            $selectedTime = Carbon::parse($carTime);
            $startTime = Carbon::parse('09:00');
            $endTime = Carbon::parse('20:00');
            if ($selectedTime->lt($startTime) || $selectedTime->gte($endTime)) {
                return response()->json(['error' => 'Selected time is not available. Please choose a time between 09:00 and 20:00.'], 400);
            }
            
            $currentDateTime = now();
    
            if ($currentDateTime->format('Y-m-d') >= $carDate) {
                return response()->json(['error' => 'Invalid date. Please choose a future date.'], 400);
            }
    
            // Здійсніть збереження замовлення, оскільки всі перевірки пройдено
            $activeCar = Car::where('is_active', true)->where('user_id', auth()->id())->first();
    
            // Check if the user has an active car
            if (!$activeCar) {
                return response()->json(['error' => 'Active Car not found.'], 400);
            }
    
            $activeServiceId = session('activeServiceId');
    
            // Check if the activeServiceId is available in the session
            if (!$activeServiceId) {
                return response()->json(['error' => 'Active ServiceId not found.'], 400);
            }
    
            // Create the order
            $order = Order::create([
                'user_id' => Auth::id(),
                'car_id' => $activeCar->car_id,
                'service_id' => $activeServiceId,
                'car_date' => $carDate,
                'car_time' => $carTime,
                'order_date' => $currentDateTime,
            ]);
    
            // Log the received serviceId
            \Log::info('Received serviceId for order: ' . $activeServiceId);
            \Log::info('Car Date: ' . $carDate);
            \Log::info('Car Time: ' . $carTime);
            \Log::info('Order date: ' . $order->order_date);
    
            // Перевірте, чи замовлення створено успішно
            if ($order) {
                session()->forget('car_date');
                session()->forget('car_time');
                session()->forget('service_id');
                return response()->json(['message' => 'Order created successfully']);
            } else {
                \Log::error('Failed to create order for user ' . Auth::id());
                return response()->json(['error' => 'Failed to create order'], 500);
            }
        } catch (\Exception $e) {
            // Log the exception
            \Log::error('Error creating order: ' . $e->getMessage());
    
            return response()->json(['error' => 'Failed to create order'], 500);
        }
    }
    public function showActiveCar()
    {
        $activeCar = Auth::user()->activeCar;

        return view('cars.show_active_car', ['activeCar' => $activeCar]);
    }
    public function showOrderForm()
    {
        $cars = Car::all();
        $activeCar = Car::where('is_active', true)->where('user_id', auth()->id())->first();
        return view('pages.order.form', compact('cars', 'activeCar'));
    }

    public function store(Request $request)
{
    $activeCar = Auth::user()->activeCar;

    // Check if the user has an active car
    if (!$activeCar) {
        return response()->json(['error' => 'Active Car not found.'], 400);
    }
    
    $activeServiceId = session('activeServiceId');
    
    // Check if the activeServiceId is available in the session
    if (!$activeServiceId) {
        return response()->json(['error' => 'Active ServiceId not found.'], 400);
    }
    
    // Retrieve car_date and car_time from the session
    $carDate = $request->input('car_date');
    $carTime = $request->input('car_time');
    // Validate car_date and car_time
    if (!$carDate || !$carTime) {
        return response()->json(['error' => 'Invalid car date or time.'], 400);
    }
    
    // Validate the working hours (9:00 - 20:00) and working day
    $selectedTime = Carbon::parse($carTime);
    $startTime = Carbon::parse('09:00:00');
    $endTime = Carbon::parse('20:00:00');
    
    if ($selectedTime->lt($startTime) || $selectedTime->gte($endTime)) {
        return response()->json(['error' => 'Selected time is not available. Please choose a time between 09:00 and 20:00.'], 400);
    }
    
    $currentDateTime = now();
    
    if ($currentDateTime->format('Y-m-d') >= $carDate) {
        return response()->json(['error' => 'Invalid date. Please choose a future date.'], 400);
    }
    
    // Create the order
    try {
        $order = Order::create([
            'user_id' => Auth::id(),
            'car_id' => $activeCar->car_id,
            'service_id' => $activeServiceId,
            'car_date' => $carDate,
            'car_time' => $carTime,
            'order_date' => now(),
        ]);
    
        // Log the received serviceId
        \Log::info('Received serviceId for order: ' . $activeServiceId);
    
        // Check if the order was created successfully
        if ($order) {
            session()->forget('car_date');
            session()->forget('car_time');
            return response()->json(['message' => 'Order created successfully']);
        } else {
            \Log::error('Failed to create order for user ' . Auth::id());
            return response()->json(['error' => 'Failed to create order'], 500);
        }
    } catch (\Exception $e) {
        \Log::error('Error creating order: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to create order'], 500);
    }
}
}