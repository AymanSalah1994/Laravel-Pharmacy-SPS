<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\UserRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    //
    // $post       = new Post();
    // // BUG NOT Fine WITH ASSOC ARR METHOD
    // if ($request->hasFile('postImage')) {
    //     $picture     = $request->postImage;
    //     $fileName    = Storage::putFile('postsImages', $picture);
    //     $post->image = $fileName;
    // }
    // $post->save();

    public function register(CustomerRequest $customerRequest, UserRequest $request)
    {
        $message = "";
        $customer = new Customer();
        $customer->dob  = $customerRequest->post('dob');
        $customer->gender  = $customerRequest->post('gender');
        $customer->national_id  = $customerRequest->post('national_id');
        $customer->profile_image = $customerRequest->file('profile_image');
        $customer->mobile_number  = $customerRequest->post('mobile_number');

        $userCustomer  = new User();
        $userCustomer->assignRole('user');
        $userCustomer->name = $request->post('name');
        $userCustomer->email = $request->post('email');
        $userCustomer->password = Hash::make($request->post('password'));
        // Password Confirmation
        if ($request->post('password') !== $request->post('confirm_password')) {
            return response()->json([
                'message' => 'The password confirmation does not match.'
            ], 422);
        }
        $customer->users()->save($userCustomer);
        // event(new Registered($userCustomer));
        $userCustomer->sendEmailVerificationNotification();
        return response()->json([
            'message' => 'Account created , Use the Email Sent to you and Log in To Verify'
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'       => 'required|email',
            'password'    => 'required',
            "device_name" => 'nullable'
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $token  = $user->createToken("devoo")->plainTextToken;
        return response()->json([
            'token' => $token
        ]);
        // TODO : Sending User Data With Token  ;


    }


    public function updateProfile(Request $request)
    {
        if ($request->input('email')) {
            return response()->json([
                'Error' => "No"
            ]);
        } else {
            $userId = auth('sanctum')->user()->id ;
            return response()->json([
                'Your Id ' => $userId ,
                'Success' => "Everything OK"
            ]);
        }
    }
}
