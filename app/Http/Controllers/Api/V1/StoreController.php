<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\V1\UserStoreResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserStore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class StoreController extends Controller
{
    public function store()
    {
        $userStore = Auth::user()->userstore;
        $response = [
            'status' => 201,
            'store' => $userStore       //if store comes with info not needed, use resource file to filter
        ];

        return new UserStoreResource($userStore);
        // return response()->json($Response);
    }

    public function updateStore(Request $request)
    {
        // Validate request data
        $fields = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'postcode' => 'string',
            'current_location' => 'string',
            'description' => 'required|string',
            'food_cert_number' => 'string',
            'food_cert' => 'string',
            'account_number' => 'string',
            'sort_code' => 'string',
            'bank' => 'string',
            'availability' => 'boolean',  // Assuming availability is a boolean value
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Check if the user has a store
        if (!$user->userstore) {
            // Create a new store for the user
            $store = $user->userstore()->create([
                'name' => $fields['name'],
                'phone' => $fields['phone'],
                'address' => $fields['address'],
                'city' => $fields['city'],
                'state' => $fields['state'],
                'postcode' => $fields['postcode'] ?? null,
                'current_location' => $fields['current_location'] ?? null,
                'description' => $fields['description'],
                'food_cert_number' => $fields['food_cert_number'] ?? null,
                'food_cert' => $fields['food_cert'] ?? null,
                'account_number' => $fields['account_number'] ?? null,
                'sort_code' => $fields['sort_code'] ?? null,
                'bank' => $fields['bank'] ?? null,
                'availability' => 1,
            ]);

            // Return a success response with a 201 status code
            return response()->json([
                'status' => 201,  // Use 201 for successful creation
                'store' => $store,
                'message' => 'Store created successfully.'
            ], 201);
        }

        // Update the existing store with validated fields
        $user->userstore->update($fields);

        // Return a success response with a 200 status code
        return response()->json([
            'status' => 200,  // Use 200 for successful update
            'message' => 'Store updated successfully.'
        ]);
    }
}
