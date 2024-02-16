<?php
// app/Http/Controllers/Api/ForgotPasswordController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use DB;
use Illuminate\Support\Facades\Hash;
class ForgotPasswordController extends Controller
{
  
    public function set_new_password(Request $request)
    {
      $email =$request->email; // Replace with the user's email
$userProvidedToken = $request->token; // Replace with the token provided by the user

// Fetch the hashed token from the password_resets table based on the user's email
$tokenRecord = DB::table('password_resets')->where('email', $email)->first();

if ($tokenRecord) {
    // Compare the user-provided token with the hashed token from the database
    if (Hash::check($userProvidedToken, $tokenRecord->token)) {
        // The tokens match, proceed with the password reset
        // For example, redirect to the password reset form
          $res = DB::table('users')->where('email', $email)->update(['password' => bcrypt($request->password)]);

        return response()->json(['error' => 'Password Changed  successfully.'], 200);;
    } else {
        // The tokens do not match, handle accordingly
        return response()->json(['error' => 'Invalid token'], 422);
    }
} else {
    // Token record not found in the database, handle accordingly
    return response()->json(['error' => 'Token not found'], 404);
}
  
    }
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? response()->json(['message' => trans($response)], 200)
            : response()->json(['error' => trans($response)], 422);
    }

    protected function broker()
    {
        return Password::broker();
    }
}