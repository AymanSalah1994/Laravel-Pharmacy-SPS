<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAddressRequest;
use App\Http\Resources\UserAddressResource;
use App\Models\UserAddress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param UserAddressRequest $request
     * @return JsonResponse
     */
    public function store(UserAddressRequest $request): JsonResponse
    {
        $user = auth()->user();
        $address = new UserAddress($request->validated());
        $address->customer_id = $user->id;
        $address->save();

        return response()->json(new UserAddressResource($address), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param UserAddress $userAddress
     * @return JsonResponse
     */
    public function show(UserAddress $userAddress): JsonResponse
    {
        $this->authorize('view', $userAddress);

        return response()->json(new UserAddressResource($userAddress));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserAddressRequest $request
     * @param UserAddress $userAddress
     * @return JsonResponse
     */
    public function update(UserAddressRequest $request, UserAddress $userAddress): JsonResponse
    {
        $this->authorize('update', $userAddress);

        $userAddress->update($request->validated());

        return response()->json(new UserAddressResource($userAddress));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param UserAddress $userAddress
     * @return JsonResponse
     */
    public function destroy(UserAddress $userAddress): JsonResponse
    {
        $this->authorize('delete', $userAddress);

        $userAddress->delete();

        return response()->json(null, 204);
    }
}
