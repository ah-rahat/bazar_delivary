<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\otptoken;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected function sendResetResponse(Request $request, $response)
    {
        return response(['message' => trans($response)]);

    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return response(['error' => trans($response)], 422);
    }


    protected function update_profile(Request $request)
    {
        $checkIfUserExist = DB::table('users')->where('id', $request->customer_id)->count();

        if ($checkIfUserExist == 1) {
            $ph = $request->phone;
            $password = Hash::make($request->password);
               $data =  User::where('id', $request->customer_id)->update([
                    'name' => $request->name,
                    'password' => $password,
                    'phone' => $ph,
                ]);
//            $update = DB::table('users')->where('id', $request->customer_id)->update(
//                [
//                    'name' => $request->name,
//                    'password' => $password,
//                    'phone' => $ph,
//                ]);

                return response()->json([
                    'user' => DB::table('users')->where('id', $request->customer_id)->first(),
                    'status' => '30',
                ]);
        }
    }

    protected function resetpassword(Request $request)
    {
        $checkIfUserExist = DB::table('users')->where('phone', $request->phone)->count();
        //0 means  user  not exist

        if ($checkIfUserExist == 1) {
            $ph = $request->phone;
            $password = Hash::make($request->password);

            $matchThese = ['phone' => '88' . $request->phone, 'token' => $request->token];
            $match_token = otptoken::where($matchThese)->count();

            if ($match_token == 1) {

                User::where('phone', $ph)->update(['password' => $password]);

                return response()->json([
                    'message' => "<span class='green-color'><i class='fa fa-exclamation-triangle'></i>  New Password set successfully.</span>",
                    'status' => '30',
                ]);

            } else {

                return response()->json([
                    'message' => "<span class='red-color'><i class='fa fa-exclamation-triangle'></i>Sorry Something wrong Try again.</span>",
                    'status' => '31',
                ]);
            }

        } else {
            return response()->json([
                'message' => "Sorry User Does  not found with this number <b class='green-color'>+$request->phone</b>.",
                'status' => '32',
            ]);
        }
    }


}
