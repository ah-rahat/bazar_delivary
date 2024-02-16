<?php

// app/Http/Controllers/Auth/ForgotPasswordController.php

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotApiPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    // Override the sendResetLinkEmail method to customize the logic
    protected function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

    // Customize the success response if needed
    protected function sendResetLinkResponse($response)
    {
        return back()->with('status', trans($response));
    }

    // Customize the failed response if needed
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()->withErrors(
            ['email' => trans($response)]
        );
    }
}