<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function createStaff(Request $request){

        try{
        //Validated
        $validateUser = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:staff,email',
                'password' => 'required'
            ]);

        if($validateUser->fails()){
            
        
            return response()->json([
                'data'=>[
                    'message'=>'The given data was invalid.',
                    'errors'=>$validateUser->errors()
                ]], 401);
        }

        $user = Staff::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
//         event(new Registered($user));


         return response()->json([
            'status' => true,
            'message' => 'Staff Created Successfully',
        ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function login(Request $request){
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            $user = Staff::where('email', $request->email)->first();
//            if ($user->email_verified_at) {
                if(!Auth::guard('jwt-staff')->attempt($request->only(['email', 'password']))){
                    return response()->json([
                        'status' => false,
                        'message' => 'Email & Password does not match with our record.',
                    ], 401);
                }


                $token = $user->createToken("token",["jwt-staff"])->plainTextToken;

                if(env('APP_ENV') != 'local'){
                    $cookie = cookie('jwt-staff', $token, 60 * 24)
                            ->withSameSite('none')
                            ->withSecure(true);
                }else{
                    $cookie = cookie('jwt-staff', $token, 60 * 24)
                            ->withSameSite('none');
                }
                

                return response()->json([
                    'status' => true,
                    'message' => 'User Logged In Successfully'
                ], 200)->withCookie($cookie);
//            }
//            return response()->json([
//                'status' => false,
//                'message' => 'Email not verified! Please verify your email before login',
//            ], 401);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function verifyEmail($id, Request $request){
        if (!$request->hasValidSignature()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid/Expired url provided.'
            ], 401);
        }
        try {
            $user = Staff::findOrFail($id);
            if (! $user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();

                event(new Verified($user));
            }
            return response()->json([
                'status' => true,
                'message' => 'Email verified.',
            ], 200);
        }catch (\Exception $ex){
            return response()->json([
                'status' => false,
                'message' => $ex->getMessage()
            ], 500);
        }

    }
    public function resendVerification() {
        try {
            if (auth()->user()->hasVerifiedEmail()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email already verified.'
                ], 400);
            }
            auth()->user()->sendEmailVerificationNotification();

            return response()->json([
                'status' => true,
                'message' => 'Email verification link sent on your email id'
            ], 200);
        }catch (\Exception $ex){
            return response()->json([
                'status' => false,
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function getCurrentUser(Request $request){
        return response()->json(['data' => $request->user()], 200);
    }

    public function logout(Request $request){
        $cookie = Cookie::forget('jwt-staff');
        return response()->json([
            'status' => true,
            'message' => 'Success'
        ], 200)->withCookie($cookie);
    }

}
