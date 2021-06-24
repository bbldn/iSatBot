<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

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