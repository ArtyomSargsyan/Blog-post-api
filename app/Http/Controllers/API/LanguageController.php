<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function app;
use function response;

class LanguageController extends Controller
{
    public function changeLanguage(Request $request, $lang): \Illuminate\Http\JsonResponse
    {

        if ($lang) {
            app()->setLocale($lang);

            return response()->json(['message' => 'Language changed successfully']);
        }

        return response()->json(['error' => 'Invalid language'], 400);
    }
}
