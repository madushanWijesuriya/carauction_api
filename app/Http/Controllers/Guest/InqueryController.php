<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Inquery;
use App\Models\Staff;
use Exception;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;

class InqueryController extends Controller
{
    public function index(Request $request){

    }

    public function store(Request $request){
        try{
            $result = DB::transaction(function () use ($request) {
                $inquery = Inquery::create($request->all());

                return $inquery;
            });

            if($result){
                return response()->json(['message' => 'Successfully Added'],200);
            }
        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
        }
    }

}
