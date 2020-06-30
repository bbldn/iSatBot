<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class MainController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction(): Response
    {
        return response()->json(['ok' => true]);
    }
}
