<?php

namespace App\Exceptions\Screenshots;

use Exception;
use Illuminate\Http\Request;

class FileAlreadyExists extends Exception
{
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render(Request $request)
    {
        return response()
            ->json([
            'success' => false,
            'screenshot' => null,
            'error' => 'File does already exists.',
            ], 500);
    }
}
