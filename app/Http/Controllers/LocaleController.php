<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function changeLanguage(Request $request, $language)
    {
        $request->session()->put('language', $language);

        return redirect()->back();
    }
}
