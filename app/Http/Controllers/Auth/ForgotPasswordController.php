<?php 
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

use App\Mail\SendImageMail;
use Illuminate\Support\Facades\Mail;

use App\Mail\SendPDFEmail;
class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

   

// public function sendImageEmail()
// {
//     $imagePath = public_path('images/Screenshot.png');
//     $imageName = 'Screenshot.png';

//     Mail::to('jaisinghdangi64@gmail.com')->send(new SendImageMail($imagePath, $imageName));

//     return response()->json(['message' => 'Email with image sent successfully']);
// }
// public function sendImageEmail()
// {
//     $imagePath = public_path('images/Screenshot.png');
//     $imageName = 'Screenshot.png';

//     Mail::to('jaisinghdangi64@gmail.com')->send(new SendImageMail($imagePath, $imageName));

//     return response()->json(['message' => 'Email with image sent successfully']);
// }

public function sendImageEmail(Request $request)
{
    $imagePath = storage_path('app/public/images/Screenshot.png'); // Specify the path to your image
    $imageName = 'Screenshot.png';
    Mail::to('jaisinghdangi64@gmail.com')->send(new SendImageMail($imagePath,$imageName));

    return response()->json(['message' => 'Email sent successfully']);
}


public function sendEmailWithPDF(Request $request)
{
    $pdfPath = storage_path('app/public/images/example.pdf'); // Replace with your actual PDF path

    Mail::to('jaisinghdangi64@gmail.com')
        ->send(new SendPDFEmail($pdfPath));
        return response()->json(['message' => 'Email sent successfully']);

    // Optionally, you can check if the email was sent successfully
    // if (Mail::failures()) {
    //     return response()->json(['message' => 'Email not sent']);
    // } else {
    //     return response()->json(['message' => 'Email sent successfully']);
    // }
}
}
