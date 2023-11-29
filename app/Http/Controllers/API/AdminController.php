<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\SendUserMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use function response;

class AdminController extends Controller
{
    public function checkUser(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $user = User::find($id);
        if ($user->status == 'active') {

            $user->status = $request->input('status');
            $user->save();

            $content = [
                'subject' => 'mail subject',
                'body' => $user->email . 'This account is blocked admin connect admin'
            ];
            Mail::to($user['email'])->send(new SendUserMail($content));
            return response()->json(['success' => 'This Account is blocked ', 'user' => $user]);
        } else {
             return response()->json(['account is blocked']);
        }

    }


}
