<?php

namespace App\Http\Controllers;

// use Bunny\Storage\Client;
use Bunny\Storage\Client;
use Bunny\Storage\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;

class UserStoreController extends BaseController
{
    public $apiAccessKey;
    public $storageZoneName;
    public $storageZoneRegion;
    public $client;

    public function __construct()
    {
        $this->apiAccessKey = config('services.bunnynetcdn.api_access_key');
        $this->storageZoneName = config('services.bunnynetcdn.storage_zone_name');
        $this->storageZoneRegion = config('services.bunnynetcdn.storage_zone_region');

        if ($this->apiAccessKey && $this->storageZoneName) {
            $this->client = new Client($this->apiAccessKey, $this->storageZoneName, Region::LONDON);
        }
    }

    public function index()
    {
        $pageTitle = 'Store';  // Set the page title for this view
        $userStoreCheck = $this->checkUserStore();
        $newOrdersCount = $userStoreCheck['newOrdersCount'];
        return view('store', compact('pageTitle', 'userStoreCheck', 'newOrdersCount'));
    }

    public function updateStore(Request $request)
    {
        $user = auth()->user();
        $existingStore = $user->userstore;

        $fields = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'postcode' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'food_cert_number' => ['nullable', 'string', 'max:255'],
            'food_cert' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
            'account_number' => ['nullable', 'string', 'max:255'],
            'sort_code' => ['nullable', 'string', 'max:255'],
            'bank' => ['nullable', 'string', 'max:255'],
        ]);

        $user->userstore()->updateOrCreate(
            ['user_id' => $user->id], // column/value pairs to find
            [ // column/value pairs to update or create
                'name' => $fields['name'],
                'phone' => $fields['phone'],
                'address' => $fields['address'],
                'city' => $fields['city'],
                'state' => $fields['state'],
                'postcode' => $fields['postcode'] ?? null,
                // 'current_location' => $request->current_location,    //fixme - get the current location
                'description' => $fields['description'],
                'food_cert_number' => $fields['food_cert_number'] ?? null,
                'food_cert' => $request->hasFile('food_cert')
                    ? $this->uploadFoodCert($request->file('food_cert'))
                    : optional($existingStore)->food_cert,
                'account_number' => $fields['account_number'] ?? null,
                'sort_code' => $fields['sort_code'] ?? null,
                'bank' => $fields['bank'] ?? null,
                // 'availability' => $request->availability,        //use toggle button
                'logo' => optional($existingStore)->logo,
                'cover_image' => optional($existingStore)->cover_image,
                // There is no approval flow implemented in this repo, so local stores
                // should become usable immediately.
                'status' => 'a',
            ]
        );

        return back()->with('success', $existingStore ? 'Store updated successfully.' : 'Store created successfully.');
    }

    private function uploadFoodCert($file)
    {
        // Get file extension
        $extension = $file->getClientOriginalExtension();
        // Generate unique filename
        $fileName = time() . '_1.' . $extension;

        if ($this->client) {
            $this->client->upload($file->getRealPath(), 'documents/foodcertificates/' . $fileName);
            return 'https://foodgre.b-cdn.net/documents/foodcertificates/' . $fileName;
        }

        $path = $file->storeAs('foodcertificates', $fileName, 'public');
        return Storage::url($path);
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => ['required', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('logo')) {
            $foodies = Auth::user()->userstore;
            if ($foodies) {
                $extension = $request->logo->getClientOriginalExtension();
                $logoName = time() . '_1.' . $extension;

                if ($this->client) {
                    $this->client->upload($request->file('logo')->getRealPath(), 'images/logos/' . $logoName);
                    $foodies->logo = 'https://foodgre.b-cdn.net/images/logos/' . $logoName;
                } else {
                    $path = $request->file('logo')->storeAs('logos', $logoName, 'public');
                    $foodies->logo = Storage::url($path);
                }

                $foodies->save();
            } else {
                return back()->with('error', 'You need to create a store first before uploading a logo.');
            }
        }
        return back()->with('success', "Logo updated successfully");
    }

    // public function updateStoreAvailability(){
    // 'availability' => $request->availability,        //use toggle button
    // }
}
