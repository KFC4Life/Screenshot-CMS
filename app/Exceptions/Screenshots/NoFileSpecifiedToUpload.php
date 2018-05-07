<?php

namespace App\Exceptions\Screenshots;

use Exception;

class NoFileSpecifiedToUpload extends Exception
{
    public function report()
    {
        //
    }

    public function render()
    {
        return response()->json([
            'success' => false,
            'screenshot' => [],
            'error' => 'Please give a file to upload.',
        ], 500);
    }
}
