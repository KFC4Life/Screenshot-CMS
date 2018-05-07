<?php

namespace App\Exceptions\Screenshots;

use Exception;
use Illuminate\Support\Facades\Request;

class NoApiTokenSpecifiedToValidate extends Exception
{
    public function report()
    {
        //
    }

    public function render(Request $request)
    {
        return response()->json([
            'success' => false,
            'screenshot' => [],
            'error' => 'Please give a api key to validate.',
        ], 500);
    }
}
