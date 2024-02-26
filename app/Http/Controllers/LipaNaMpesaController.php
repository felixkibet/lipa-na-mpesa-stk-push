<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class LipaNaMpesaController extends Controller
{
    public function index()
    {
        return view('lipa-na-mpesa');
    }

    public function generateToken()
    {
        // Safaricom M-PESA credentials
        $consumerKey = env('MPESA_CONSUMER_KEY');
        $consumerSecret = env('MPESA_CONSUMER_SECRET');

        // Prepare Basic Authentication credentials
        $credentials = base64_encode("$consumerKey:$consumerSecret");

        // Make a GET request to generate the access token
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $credentials,
        ])->get('https://sandbox.safaricom.co.ke/oauth/v1/generate', [
            'grant_type' => 'client_credentials',
        ]);

        return $response;
    }

    public function initiatePayment(Request $request)
    {
        // Obtain the access token
        $tokenResponse = $this->generateToken();

        $tokenData = $tokenResponse->json(); // This line will throw an error if $tokenResponse is an array
        $token = $tokenData['access_token'];

        $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        // Parameters for the M-PESA API request
        $businessShortCode = env('MPESA_BUSINESS_SHORT_CODE');
        $passKey = env('MPESA_PASSKEY');
        //$timestamp = date('YmdHis');
        $timestamp = Carbon::now()->format('YmdHis');
        $password = base64_encode($businessShortCode . $passKey . $timestamp);

        $data = [
            "BusinessShortCode" => $businessShortCode,
            "Password" => $password,
            "Timestamp" => $timestamp,
            "TransactionType" => "CustomerPayBillOnline",
            "Amount" => $request->input('amount'),
            "PartyA" => $request->input('phoneno'),
            "PartyB" => $businessShortCode,
            "PhoneNumber" => $request->input('phoneno'),
            "CallBackURL" => env('MPESA_CALLBACK_URL'),
            "AccountReference" => "Chebai Technologies",
            "TransactionDesc" => "Payment of X",
        ];

        try {
            $response = Http::withToken($token)->post($url, $data);
        } catch (RequestException $e) {
            echo $e->getMessage();
        }

        return $response->json();
    }

    public function handleCallback(Request $request)
    {
        try {
            // Retrieve the callback data
            $data = $request->all();
            $filename = now()->format('Y-m-d_H-i-s') . '.json';

            if (!empty($data)) {
                Storage::put($filename, json_encode($data));

                // Return a success response
                return response()->json(['message' => 'Callback data stored successfully'], 200);
            } else {
                // If the callback data is empty, return an error response
                return response()->json(['error' => 'Empty callback data'], 400);
            }
        } catch (\Exception $e) {
            // If an exception occurs, return an error response
            return response()->json(['error' => 'Failed to handle callback: ' . $e->getMessage()], 500);
        }
    }
}
