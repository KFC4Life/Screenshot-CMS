<?php

namespace App\Exceptions\Screenshots;

use Exception;
use Illuminate\Support\Facades\Request;

class FileTypeNotSupported extends Exception
{
    public function report()
    {

    }

    public function render(Request $request)
    {
        return response()->json([
            'success' => false,
            'screenshot' => [],
            'error' => 'We don\'t support that file type!',
        ]);
    }
}
