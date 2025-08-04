<?php

namespace Modules\Profile\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Profile\Http\Requests\StoreAddressRequest;
use Modules\Profile\Http\Requests\UpdateAddressRequest;

class AddressController extends Controller
{
    public function store(StoreAddressRequest $request)
    {
        $user = $request->user();

        $address = $user->addresses()->create($request->validated());

        return response()->json(['message' => 'Address added successfully', 'address' => $address]);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $addresses = $user->addresses;

        return response()->json(['addresses' => $addresses]);
    }

    public function destroy($id)
    {
        $address = auth()->user()->addresses()->findOrFail($id);
        $address->delete();

        return response()->json(['message' => 'Address deleted successfully']);
    }

    public function update(UpdateAddressRequest $request, $id)
    {
        $address = auth()->user()->addresses()->findOrFail($id);
        $address->update($request->validated());

        return response()->json(['message' => 'Address updated successfully', 'address' => $address]);
    }
}
