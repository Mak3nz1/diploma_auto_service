<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Service;
use App\Models\OrderDetail;
use App\Models\PaymentMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
class PaymentController extends Controller
{
        // Додавання маркера в сесійне сховище
public function addMarkerToSession(Request $request)
{
    $latitude = $request->input('latitude');
    $longitude = $request->input('longitude');

    $markers = session('markers', []);
    $markers[] = ['latitude' => $latitude, 'longitude' => $longitude];
    session(['markers' => $markers]);

    // Log the added marker
    Log::info('Marker added to session: Latitude - ' . $latitude . ', Longitude - ' . $longitude);

    return response()->json(['message' => 'Marker added to session']);
}

// Відображення маркерів з сесійного сховища на карті
public function displayMarkersFromSession()
{
    $markers = session('markers', []);

    // Log the markers retrieved from session
    Log::info('Markers retrieved from session: ' . json_encode($markers));

    return response()->json(['markers' => $markers]);
}

// Оновлення маркера в сесійному сховищі
public function updateMarkerInSession(Request $request)
{
    $index = $request->input('index');
    $latitude = $request->input('latitude');
    $longitude = $request->input('longitude');

    $markers = session('markers', []);
    $markers[$index] = ['latitude' => $latitude, 'longitude' => $longitude];
    session(['markers' => $markers]);

    // Log the updated marker
    Log::info('Marker updated in session at index ' . $index . ': Latitude - ' . $latitude . ', Longitude - ' . $longitude);

    return response()->json(['message' => 'Marker updated in session']);
}

// Видалення маркера з сесійного сховища
public function deleteMarkerFromSession(Request $request)
{
    $index = $request->input('index');

    $markers = session('markers', []);
    array_splice($markers, $index, 1);
    session(['markers' => $markers]);

    // Log the deleted marker
    Log::info('Marker deleted from session at index ' . $index);

    return response()->json(['message' => 'Marker deleted from session']);
}
    /**
     * Display the payment form with order details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function showForm(Request $request)
    {
        // Get the last order for the authenticated user
        $lastOrder = Order::where('user_id', auth()->id())->latest('order_date')->first();
        $orderId = $lastOrder ? $lastOrder->order_id : null;
        // Load the 'service' relationship
        $lastOrder->load('service');
        // Initialize $promoCode to null
        $promoCode = null;
        $totalAmount = 0;
        $discountAmount = 0;
    
        // Check if a last order exists
        if ($lastOrder) {
            $couponCode = $request->input('promo_code');
            $coupon = Coupon::where('code', $couponCode)->first();
            $service = $coupon ? Service::find($coupon->service_id) : null;
    
            // Check if a service is associated with the coupon
            if ($service) {
                // Set $totalAmount to the service's price
                $totalAmount = $service->getPrice();
                
                // Check if a promo code is provided
                if ($coupon) {
                    // Calculate discountAmount if the coupon is valid
                    $discountAmount = ($totalAmount * $coupon->discount_percentage / 100);
                }
            }
        }
    
        // Retrieve payment methods and addresses from the database
        $paymentMethods = PaymentMethod::all();
    
        // Pass variables to the view
        return view('pages.payment', [
            'orderId' => $orderId,
            'paymentMethods' => PaymentMethod::all(),
            'totalAmount' => $lastOrder->service ? $lastOrder->service->getPrice() : 0,
            'discountAmount' => $discountAmount, // Adjust this based on your logic
            'promoCode' => null,  // Adjust this based on your logic
            'service' => $lastOrder->service,
        ]);
    }

    /**
     * Get the payment method name by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPaymentMethodName($id)
    {
        try {
            // Find the payment method by ID
            $paymentMethod = PaymentMethod::findOrFail($id);

            // Return the JSON response with the payment method name
            return response()->json(['name' => $paymentMethod->method_name]);
        } catch (\Exception $e) {
            // Handle the exception and return an error response
            return response()->json(['error' => 'Failed to retrieve payment method name: ' . $e->getMessage()], 500);
        }
    }

    public function calculateTotal(Request $request)
    {
        try {
            $promoCode = $request->promo_code;
            $totalAmount = $request->totalAmount;

            // Check if the promo code is provided
            if (!$promoCode) {
                // If no promo code provided, return the total amount and discount amount as is
                return response()->json(['totalAmount' => $totalAmount, 'discountedAmount' => $totalAmount]);
            }

            // Validate promo code
            $validator = validator(['promo_code' => $promoCode], [
                'promo_code' => 'required', // Add any additional validation rules if needed
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => 'Invalid promo code'], 422);
            }

            // Get data from the database for the coupon
            $coupon = Coupon::where('code', $promoCode)->first();

            // Log coupon and totalAmount before the calculation
            Log::debug('Coupon: ' . print_r($coupon ? $coupon->toArray() : 'Not found', true));
            Log::debug('Total Amount: ' . $totalAmount);

            // Calculate the discounted amount based on the coupon's discount percentage
            $discountAmount = $coupon ? ($totalAmount * $coupon->discount_percentage / 100) : 0;

            // Log the calculated discounted amount
            Log::debug('Discounted Amount: ' . $discountAmount);

            // Calculate the final discounted amount
            $discountedAmount = $totalAmount - $discountAmount;
            Log::debug('Discounted Amount: ' . $discountedAmount);
    
            $discountedAmount = $totalAmount - $discountAmount;
            Log::debug('Discounted Amount: ' . $discountedAmount);
    
            return response()->json(['totalAmount' => number_format($totalAmount, 2), 'discountedAmount' => number_format($discountedAmount, 2)]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
    public function placeOrder(Request $request)
    {
        try {
            // Get the authenticated user's ID
            $userId = auth()->id();
            $totalAmount = $request->totalAmount;
    
            if (!$userId) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }
    
            // Get the last order's order_date
            $lastOrder = Order::where('user_id', $userId)->latest('order_date')->first();
            $orderId = optional($lastOrder)->order_id;
    
            $promoCode = $request->promo_code;
    
            // Check if the promo code is provided
            if ($promoCode) {
                // Validate promo code
                $validator = validator(['promo_code' => $promoCode], [
                    'promo_code' => 'required', // Add any additional validation rules if needed
                ]);
    
                if ($validator->fails()) {
                    return response()->json(['error' => 'Invalid promo code'], 422);
                }
    
                // Get data from the database for the coupon
                $coupon = Coupon::where('code', $promoCode)->first();
    
                // Log coupon and totalAmount before the calculation
                Log::debug('Coupon: ' . print_r($coupon ? $coupon->toArray() : 'Not found', true));
                Log::debug('Total Amount: ' . $totalAmount);
    
                // Calculate the discounted amount based on the coupon's discount percentage
                $discountAmount = $coupon
                    ? ($totalAmount * $coupon->discount_percentage / 100)
                    : 0; // Set discountAmount to 0 if no valid coupon
    
                // Log the calculated discounted amount
                Log::debug('Discounted Amount: ' . $discountAmount);
    
                $discountedAmount = $totalAmount - $discountAmount;
                Log::debug('Discounted Amount: ' . $discountedAmount);
            } else {
                // If no promo code provided, set the discounted amount to the total amount
                $discountedAmount = $totalAmount;
            }
    
            // Initialize $orderDetail after calculating $discountedAmount
            $orderDetail = new OrderDetail([
                'order_id' => $orderId,
                'address' => $request->address,
                'total_amount' => $discountedAmount,
                'promo_code' => $request->promo_code,
                'payment_method' => $request->payment_method,
                'order_date' => optional($lastOrder)->order_date, // Use the last order's date
            ]);
    
            // Set the selected_address property
            $selectedAddress = $request->input('address');
            $orderDetail->address = $selectedAddress;
            // Save order detail data to the database
            $orderDetail->save();
            return response()->json(['message' => 'Order placed successfully']);
        
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        } 
    }
    public function orderSuccess(Request $request)
    {  
               // Get the last order for the authenticated user
               $lastOrder = Order::where('user_id', auth()->id())->latest('order_date')->first();

               $lastOrder->load('orderDetails');
    
               // Access the order details for the last order
               $orderDetails = $lastOrder->orderDetails->latest('created_at')->first(); // Assuming you want the first order detail, adjust if needed
           
               return view('pages.order.success', [
                   'orderDetail' => [
                       'order_id' => $orderDetails->order_id ?? 'Not specified',
                       'total_amount' => $orderDetails->total_amount ?? 'Not specified',
                       'payment_method' => $orderDetails->payment_method ?? 'Not specified',
                       'address' => $orderDetails->address ?? 'Not specified',
                   ],
               ]);
        

    return view('pages.order.success', compact('orders'));
    }

}  