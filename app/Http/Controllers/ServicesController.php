<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    public function showServices(Request $request)
    {
        // Assuming you want to retrieve services from the database
        $services = DB::table('services')->get();

        return view('pages.services', ['services' => $services]);
    }

    public function submitForm(Request $request)
{
    // Retrieve the selected service ID from the hidden input
    $selectedServiceId = $request->input('service_id');

    // Fetch the complete details of the selected service
    $selectedService = DB::table('services')->find($selectedServiceId);

    // Check if the selected service is found
    if ($selectedService) {
        // Example: Log the selected service details
        Log::info('Selected Service: ' . json_encode($selectedService));

        // Example: Store the selected service details in a session
        $request->session()->put('selectedService', $selectedService);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Form submitted successfully.');
    } else {
        // Redirect back with an error message if the selected service is not found
        return redirect()->back()->with('error', 'Invalid selected service.');
    }
}
    }