<?php

namespace App\Exceptions\Screenshots;

use Exception;
use Illuminate\Support\Facades\Request;

class FileIsNotAnImage extends Exception
{
    public function report()
    {
        //
    }

    public function render(Request $request)
    {
        return response()->json([
            'success' => false,
            'screenshot' => null,
            'error' => 'File is not an image.',
        ], 500);
    }
}
