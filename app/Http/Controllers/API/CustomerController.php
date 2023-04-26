<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\UserRequest;
use App\Models\Customer;
use App\Models\User;
use App\Notifications\EmailVerified;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;


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
        $userCustomer->notify((new EmailVerified)->delay(now()->addSeconds(30)));
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
        $user_data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ];

        return response()->json([
            'token' => $token,
            'user' => $user_data
        ]);

    }


    public function updateProfile(Request $request)
    {
        $userId = auth('sanctum')->user()->id;

        $customer = Customer::where('user_id', $userId)->first();
        if (!$customer) {
            return response()->json([
                'Error' => "You don't have a customer profile"
            ], 422);
        }

        if ($request->input('email')) {
            return response()->json([
                'Error' => "You're not allowed to update email"
            ], 422);
        }

        // Validate the incoming request data
        $request->validate([
            'name' => ['string', 'max:255'],
            'password' => ['string', 'min:8', 'confirmed'],
            'gender' => Rule::in(['male', 'female']),
            'dob' => 'date',
            'national_id' => ['string', 'min:11', 'max:11'],
            'profile_image' => ['image', 'max:2048'],
            'mobile_number' => ['string', 'regex:/^[0-9]{10}$/'],
        ]);

        // Update the user's name and password if they're present in the request data
        $user = User::find($userId);
        if ($request->has('name')) {
            $user->name = $request->input('name');
        }
        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        // Update the customer's data
        $customer->gender = $request->input('gender', $customer->gender);
        $customer->dob = $request->input('dob', $customer->dob);
        $customer->national_id = $request->input('national_id', $customer->national_id);
        $customer->mobile_number = $request->input('mobile_number', $customer->mobile_number);

        // Update the customer's profile image if it's present in the request data
        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image');
            $fileName = time() . '_' . $profileImage->getClientOriginalName();
            $filePath = $profileImage->storeAs('images/profile_images', $fileName);
            $customer->profile_image = $fileName;
        }

        $customer->save();

        return response()->json([
            'Success' => "Your profile has been updated"
        ]);
    }
}
